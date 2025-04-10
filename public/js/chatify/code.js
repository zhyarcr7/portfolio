/**
 *-------------------------------------------------------------
 * Global variables
 *-------------------------------------------------------------
 */
var messenger,
  typingTimeout,
  typingNow = 0,
  temporaryMsgId = 0,
  defaultAvatarInSettings = null,
  messengerColor,
  dark_mode,
  messages_page = 1;

const messagesContainer = $(".messenger-messagingView .m-body"),
  messengerTitleDefault = $(".messenger-headTitle").text(),
  messageInputContainer = $(".messenger-sendCard"),
  messageInput = $("#message-form .m-send"),
  auth_id = $("meta[name=url]").attr("data-user"),
  url = $("meta[name=url]").attr("content"),
  messengerTheme = $("meta[name=messenger-theme]").attr("content"),
  defaultMessengerColor = $("meta[name=messenger-color]").attr("content"),
  csrfToken = $('meta[name="csrf-token"]').attr("content");

const getMessengerId = () => $("meta[name=id]").attr("content");
const setMessengerId = (id) => $("meta[name=id]").attr("content", id);

/**
 *-------------------------------------------------------------
 * Pusher initialization
 *-------------------------------------------------------------
 */
Pusher.logToConsole = chatify.pusher.debug;
let pusherChannels = {};

const initPusher = () => {
  // Only initialize once
  if (window.pusher) return;
  
  window.pusher = new Pusher(chatify.pusher.key, {
    encrypted: chatify.pusher.options.encrypted,
    cluster: chatify.pusher.options.cluster,
    wsHost: chatify.pusher.options.host,
    wsPort: chatify.pusher.options.port,
    wssPort: chatify.pusher.options.port,
    forceTLS: chatify.pusher.options.useTLS,
    authEndpoint: chatify.pusherAuthEndpoint,
    auth: {
      headers: {
        "X-CSRF-TOKEN": csrfToken,
      },
    },
    enabledTransports: ["ws", "wss"],
    disabledTransports: [],
  });

  // Connection event handlers
  window.pusher.connection.bind("state_change", function(states) {
    console.log("Pusher connection state:", states.current);
    if (states.current === "connected") {
      console.log("Pusher connected successfully");
      subscribeToActiveChannels();
    }
  });
  
  window.pusher.connection.bind("disconnected", function() {
    console.log("Pusher disconnected, attempting to reconnect...");
    setTimeout(() => {
      window.pusher.connect();
    }, 3000);
  });
  
  window.pusher.connection.bind("error", function(err) {
    console.error("Pusher connection error:", err);
    if (err.data && err.data.code === 4004) {
      console.log("Attempting to reconnect...");
      setTimeout(() => {
        window.pusher.connect();
      }, 3000);
    }
  });
};

// Keep track of subscribed channels for reconnection
function subscribeToActiveChannels() {
  if (getMessengerId()) {
    listenForNewMessages();
  }
}

// Call initialization
initPusher();

/**
 *-------------------------------------------------------------
 * Re-usable methods
 *-------------------------------------------------------------
 */
const escapeHtml = (unsafe) => {
  return unsafe
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;");
};
function actionOnScroll(selector, callback, topScroll = false) {
  $(selector).on("scroll", function () {
    let element = $(this).get(0);
    const condition = topScroll
      ? element.scrollTop == 0
      : element.scrollTop + element.clientHeight >= element.scrollHeight;
    if (condition) {
      callback();
    }
  });
}
function routerPush(title, url) {
  $("meta[name=url]").attr("content", url);
  return window.history.pushState({}, title || document.title, url);
}
function updateSelectedContact(user_id) {
  $(document).find(".messenger-list-item").removeClass("m-list-active");
  $(document)
    .find(
      ".messenger-list-item[data-contact=" + (user_id || getMessengerId()) + "]"
    )
    .addClass("m-list-active");
}
/**
 *-------------------------------------------------------------
 * Global Templates
 *-------------------------------------------------------------
 */
// Loading svg
function loadingSVG(size = "25px", className = "", style = "") {
  return `
<svg style="${style}" class="loadingSVG ${className}" xmlns="http://www.w3.org/2000/svg" width="${size}" height="${size}" viewBox="0 0 40 40" stroke="#ffffff">
<g fill="none" fill-rule="evenodd">
<g transform="translate(2 2)" stroke-width="3">
<circle stroke-opacity=".1" cx="18" cy="18" r="18"></circle>
<path d="M36 18c0-9.94-8.06-18-18-18" transform="rotate(349.311 18 18)">
<animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur=".8s" repeatCount="indefinite"></animateTransform>
</path>
</g>
</g>
</svg>
`;
}
function loadingWithContainer(className) {
  return `<div class="${className}" style="text-align:center;padding:15px">${loadingSVG(
    "25px",
    "",
    "margin:auto"
  )}</div>`;
}

// loading placeholder for users list item
function listItemLoading(items) {
  let template = "";
  for (let i = 0; i < items; i++) {
    template += `
<div class="loadingPlaceholder">
<div class="loadingPlaceholder-wrapper">
<div class="loadingPlaceholder-body">
<table class="loadingPlaceholder-header">
<tr>
<td style="width: 45px;"><div class="loadingPlaceholder-avatar"></div></td>
<td>
<div class="loadingPlaceholder-name"></div>
<div class="loadingPlaceholder-date"></div>
</td>
</tr>
</table>
</div>
</div>
</div>
`;
  }
  return template;
}

// loading placeholder for avatars
function avatarLoading(items) {
  let template = "";
  for (let i = 0; i < items; i++) {
    template += `
<div class="loadingPlaceholder">
<div class="loadingPlaceholder-wrapper">
<div class="loadingPlaceholder-body">
<table class="loadingPlaceholder-header">
<tr>
<td style="width: 45px;">
<div class="loadingPlaceholder-avatar" style="margin: 2px;"></div>
</td>
</tr>
</table>
</div>
</div>
</div>
`;
  }
  return template;
}

// While sending a message, show this temporary message card.
function sendTempMessageCard(message, id) {
  return `
 <div class="message-card mc-sender" data-id="${id}">
     <div class="message-card-content">
         <div class="message">
             ${message}
             <sub>
                 <span class="far fa-clock"></span>
             </sub>
         </div>
     </div>
 </div>
`;
}
// upload image preview card.
function attachmentTemplate(fileType, fileName, imgURL = null) {
  if (fileType != "image") {
    return (
      `
 <div class="attachment-preview">
     <span class="fas fa-times cancel"></span>
     <p style="padding:0px 30px;"><span class="fas fa-file"></span> ` +
      escapeHtml(fileName) +
      `</p>
 </div>
`
    );
  } else {
    return (
      `
<div class="attachment-preview">
 <span class="fas fa-times cancel"></span>
 <div class="image-file chat-image" style="background-image: url('` +
      imgURL +
      `');"></div>
 <p><span class="fas fa-file-image"></span> ` +
      escapeHtml(fileName) +
      `</p>
</div>
`
    );
  }
}

// Active Status Circle
function activeStatusCircle() {
  return `<span class="activeStatus"></span>`;
}

/**
 *-------------------------------------------------------------
 * Css Media Queries [For responsive design]
 *-------------------------------------------------------------
 */
$(window).resize(function () {
  cssMediaQueries();
});
function cssMediaQueries() {
  if (window.matchMedia("(min-width: 980px)").matches) {
    $(".messenger-listView").removeAttr("style");
  }
  if (window.matchMedia("(max-width: 980px)").matches) {
    $("body")
      .find(".messenger-list-item")
      .find("tr[data-action]")
      .attr("data-action", "1");
    $("body").find(".favorite-list-item").find("div").attr("data-action", "1");
  } else {
    $("body")
      .find(".messenger-list-item")
      .find("tr[data-action]")
      .attr("data-action", "0");
    $("body").find(".favorite-list-item").find("div").attr("data-action", "0");
  }
}

/**
 *-------------------------------------------------------------
 * App Modal
 *-------------------------------------------------------------
 */
let app_modal = function ({
  show = true,
  name,
  data = 0,
  buttons = true,
  header = null,
  body = null,
}) {
  const modal = $(".app-modal[data-name=" + name + "]");
  // header
  header ? modal.find(".app-modal-header").html(header) : "";

  // body
  body ? modal.find(".app-modal-body").html(body) : "";

  // buttons
  buttons == true
    ? modal.find(".app-modal-footer").show()
    : modal.find(".app-modal-footer").hide();

  // show / hide
  if (show == true) {
    modal.show();
    $(".app-modal-card[data-name=" + name + "]").addClass("app-show-modal");
    $(".app-modal-card[data-name=" + name + "]").attr("data-modal", data);
  } else {
    modal.hide();
    $(".app-modal-card[data-name=" + name + "]").removeClass("app-show-modal");
    $(".app-modal-card[data-name=" + name + "]").attr("data-modal", data);
  }
};

/**
 *-------------------------------------------------------------
 * Slide to bottom on [action] - e.g. [message received, sent, loaded]
 *-------------------------------------------------------------
 */
function scrollToBottom(container) {
  // If a specific container is provided, use it
  if (container) {
    try {
      // Force scroll with multiple methods for maximum compatibility
      var messagesContainer = $(container)[0];
      if (messagesContainer) {
        // Direct DOM method - most reliable
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
      }
      
      // Also use jQuery animate for smoother experience
      $(container).animate({
        scrollTop: $(container)[0].scrollHeight
      }, 100);
    } catch (e) {
      console.error("Error scrolling container:", e);
    }
  }
  
  // Try all possible message containers regardless (backup approach)
  try {
    // Try main container
    if ($('.messenger-messagingView .m-body').length) {
      $('.messenger-messagingView .m-body')[0].scrollTop = $('.messenger-messagingView .m-body')[0].scrollHeight;
    }
    
    // Try messages container
    if ($('.messages').length) {
      $('.messages')[0].scrollTop = $('.messages')[0].scrollHeight;
    }
    
    // For admin interface (different structure)
    if ($('.chat-messages').length) {
      $('.chat-messages')[0].scrollTop = $('.chat-messages')[0].scrollHeight;
    }
    
    // Try any scrollable message container as a last resort
    $('[data-chat-messages]').each(function() {
      this.scrollTop = this.scrollHeight;
    });
  } catch (e) {
    console.log("Fallback scroll error:", e);
  }
}

/**
 *-------------------------------------------------------------
 * click and drag to scroll - function
 *-------------------------------------------------------------
 */
function hScroller(scroller) {
  const slider = document.querySelector(scroller);
  let isDown = false;
  let startX;
  let scrollLeft;

  slider.addEventListener("mousedown", (e) => {
    isDown = true;
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
  });
  slider.addEventListener("mouseleave", () => {
    isDown = false;
  });
  slider.addEventListener("mouseup", () => {
    isDown = false;
  });
  slider.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    const walk = (x - startX) * 1;
    slider.scrollLeft = scrollLeft - walk;
  });
}

/**
 *-------------------------------------------------------------
 * Disable/enable message form fields, messaging container...
 * on load info or if needed elsewhere.
 *
 * Default : true
 *-------------------------------------------------------------
 */
function disableOnLoad(disable = true) {
  if (disable) {
    // hide star button
    $(".add-to-favorite").hide();
    // hide send card
    $(".messenger-sendCard").hide();
    // add loading opacity to messages container
    messagesContainer.css("opacity", ".5");
    // disable message form fields
    messageInput.attr("readonly", "readonly");
    $("#message-form button").attr("disabled", "disabled");
    $(".upload-attachment").attr("disabled", "disabled");
  } else {
    // show star button
    if (getMessengerId() != auth_id) {
      $(".add-to-favorite").show();
    }
    // show send card
    $(".messenger-sendCard").show();
    // remove loading opacity to messages container
    messagesContainer.css("opacity", "1");
    // enable message form fields
    messageInput.removeAttr("readonly");
    $("#message-form button").removeAttr("disabled");
    $(".upload-attachment").removeAttr("disabled");
  }
}

/**
 *-------------------------------------------------------------
 * Error message card
 *-------------------------------------------------------------
 */
function errorMessageCard(id) {
  messagesContainer
    .find(".message-card[data-id=" + id + "]")
    .addClass("mc-error");
  messagesContainer
    .find(".message-card[data-id=" + id + "]")
    .find("svg.loadingSVG")
    .remove();
  messagesContainer
    .find(".message-card[data-id=" + id + "] p")
    .prepend('<span class="fas fa-exclamation-triangle"></span>');
}

/**
 *-------------------------------------------------------------
 * Fetch id data (user/group) and update the view
 *-------------------------------------------------------------
 */
function IDinfo(id) {
  // clear temporary message id
  temporaryMsgId = 0;
  // clear typing now
  typingNow = 0;
  // show loading bar
  NProgress.start();
  // disable message form
  disableOnLoad();
  if (messenger != 0) {
    // get shared photos
    getSharedPhotos(id);
    // Get info
    $.ajax({
      url: url + "/idInfo",
      method: "POST",
      data: { _token: csrfToken, id },
      dataType: "JSON",
      success: (data) => {
        if (!data?.fetch) {
          NProgress.done();
          NProgress.remove();
          return;
        }
        // avatar photo
        $(".messenger-infoView")
          .find(".avatar")
          .css("background-image", 'url("' + data.user_avatar + '")');
        $(".header-avatar").css(
          "background-image",
          'url("' + data.user_avatar + '")'
        );
        // Show shared and actions
        $(".messenger-infoView-btns .delete-conversation").show();
        $(".messenger-infoView-shared").show();
        // fetch messages
        fetchMessages(id, true);
        
        // Force scroll to bottom when opening conversation - CRITICAL FIX
        setTimeout(function() {
          // Use both direct DOM and jQuery methods for maximum compatibility
          if (messagesContainer && messagesContainer.length) {
            messagesContainer[0].scrollTop = messagesContainer[0].scrollHeight;
            messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
          }
          
          // Try all possible selectors for both admin and user interfaces
          $('.messenger-messagingView .m-body').scrollTop($('.messenger-messagingView .m-body')[0]?.scrollHeight || 0);
          $('.messages').scrollTop($('.messages')[0]?.scrollHeight || 0);
          $('.chat-messages').scrollTop($('.chat-messages')[0]?.scrollHeight || 0);
          
          console.log("Forced scroll to bottom when opening conversation");
        }, 100);
        
        // Schedule more scroll attempts to handle delayed content rendering
        setTimeout(function() {
          scrollToBottom(messagesContainer);
        }, 300);
        
        setTimeout(function() {
          scrollToBottom(messagesContainer);
        }, 1000);
        
        // focus on messaging input
        messageInput.focus();
        // update info in view
        $(".messenger-infoView .info-name").text(data.fetch.name);
        $(".m-header-messaging .user-name").text(data.fetch.name);
        // Star status
        data.favorite > 0
          ? $(".add-to-favorite").addClass("favorite")
          : $(".add-to-favorite").removeClass("favorite");
        // form reset and focus
        $("#message-form").trigger("reset");
        cancelAttachment();
        messageInput.focus();
      },
      error: () => {
        console.error("Couldn't fetch user data!");
        // remove loading bar
        NProgress.done();
        NProgress.remove();
      },
    });
  } else {
    // remove loading bar
    NProgress.done();
    NProgress.remove();
  }
}

// Add a global auto-scroll function that works for both admin and user views
function forceScrollToBottom() {
  console.log("Force scrolling all possible message containers");
  
  // Try direct DOM approach first (most reliable)
  try {
    // Standard Chatify containers
    if (messagesContainer && messagesContainer.length) {
      messagesContainer[0].scrollTop = messagesContainer[0].scrollHeight;
    }
    
    // Try with specific selectors for all interfaces
    if (document.querySelector('.messenger-messagingView .m-body')) {
      document.querySelector('.messenger-messagingView .m-body').scrollTop = 
        document.querySelector('.messenger-messagingView .m-body').scrollHeight;
    }
    
    if (document.querySelector('.messages')) {
      document.querySelector('.messages').scrollTop = 
        document.querySelector('.messages').scrollHeight;
    }
    
    if (document.querySelector('.chat-messages')) {
      document.querySelector('.chat-messages').scrollTop = 
        document.querySelector('.chat-messages').scrollHeight;
    }
    
    // Find any element with data-chat-messages attribute
    document.querySelectorAll('[data-chat-messages]').forEach(el => {
      el.scrollTop = el.scrollHeight;
    });
  } catch (e) {
    console.error("Error in force scroll:", e);
  }
  
  // Also try jQuery methods as backup
  try {
    $('.messenger-messagingView .m-body').animate({scrollTop: $('.messenger-messagingView .m-body')[0]?.scrollHeight || 0}, 0);
    $('.messages').animate({scrollTop: $('.messages')[0]?.scrollHeight || 0}, 0);
    $('.chat-messages').animate({scrollTop: $('.chat-messages')[0]?.scrollHeight || 0}, 0);
  } catch (e) {
    console.error("Error in jQuery scroll:", e);
  }
}

/**
 *-------------------------------------------------------------
 * Send message function
 *-------------------------------------------------------------
 */
function sendMessage() {
  temporaryMsgId += 1;
  let tempID = `temp_${temporaryMsgId}`;
  let hasFile = !!$(".upload-attachment").val();
  const inputValue = $.trim(messageInput.val());
  if (inputValue.length > 0 || hasFile) {
    const formData = new FormData($("#message-form")[0]);
    formData.append("id", getMessengerId());
    formData.append("temporaryMsgId", tempID);
    formData.append("_token", csrfToken);
    $.ajax({
      url: $("#message-form").attr("action"),
      method: "POST",
      data: formData,
      dataType: "JSON",
      processData: false,
      contentType: false,
      beforeSend: () => {
        // remove message hint
        $(".messages").find(".message-hint").hide();
        // append a temporary message card
        if (hasFile) {
          messagesContainer
            .find(".messages")
            .append(
              sendTempMessageCard(
                inputValue + "\n" + loadingSVG("28px"),
                tempID
              )
            );
        } else {
          messagesContainer
            .find(".messages")
            .append(sendTempMessageCard(inputValue, tempID));
        }
        
        // Add sending animation
        const $tempMsg = messagesContainer.find(`.message-card[data-id=${tempID}]`);
        $tempMsg.addClass('message-sending');
        
        // scroll to bottom
        scrollToBottom(messagesContainer);
        forceScrollToBottom(); // Use our enhanced scroll
        
        messageInput.css({ height: "42px" });
        // form reset and focus
        $("#message-form").trigger("reset");
        cancelAttachment();
        messageInput.focus();
      },
      success: (data) => {
        if (data.error > 0) {
          // message card error status
          errorMessageCard(tempID);
          console.error(data.error_msg);
        } else {
          // update contact item
          updateContactItem(getMessengerId());
          // temporary message card
          const tempMsgCardElement = messagesContainer.find(
            `.message-card[data-id=${data.tempID}]`
          );
          
          // Remove sending animation
          tempMsgCardElement.removeClass('message-sending');
          
          // add the message card coming from the server before the temp-card
          tempMsgCardElement.before(data.message);
          
          // Add delivered animation to the new message
          const $newMsg = messagesContainer.find(`.message-card[data-id=${data.msgId}]`);
          $newMsg.addClass('message-delivered');
          
          // then, remove the temporary message card
          tempMsgCardElement.remove();
          
          // scroll to bottom
          scrollToBottom(messagesContainer);
          forceScrollToBottom(); // Use our enhanced scroll
          
          // send contact item updates
          sendContactItemUpdates(true);
          
          // Play delivered sound
          playNotificationSound('message_sent', false);
        }
      },
      error: () => {
        // message card error status
        errorMessageCard(tempID);
        // error log
        console.error(
          "Failed sending the message! Please, check your server response."
        );
      },
    });
  }
  return false;
}

/**
 *-------------------------------------------------------------
 * Fetch messages from database
 *-------------------------------------------------------------
 */
let messagesPage = 1;
let noMoreMessages = false;
let messagesLoading = false;
function setMessagesLoading(loading = false) {
  if (!loading) {
    messagesContainer.find(".messages").find(".loading-messages").remove();
    NProgress.done();
    NProgress.remove();
  } else {
    messagesContainer
      .find(".messages")
      .prepend(loadingWithContainer("loading-messages"));
  }
  messagesLoading = loading;
}
function fetchMessages(id, newFetch = false) {
  if (newFetch) {
    messagesPage = 1;
    noMoreMessages = false;
  }
  if (messenger != 0 && !noMoreMessages && !messagesLoading) {
    const messagesElement = messagesContainer.find(".messages");
    setMessagesLoading(true);
    $.ajax({
      url: url + "/fetchMessages",
      method: "POST",
      data: {
        _token: csrfToken,
        id: id,
        page: messagesPage,
      },
      dataType: "JSON",
      success: (data) => {
        setMessagesLoading(false);
        if (messagesPage == 1) {
          messagesElement.html(data.messages);
          
          // CRITICAL: Force immediate scroll after content is loaded
          console.log("Initial messages loaded - forcing scroll");
          
          // Direct DOM method (most reliable)
          try {
            messagesContainer[0].scrollTop = messagesContainer[0].scrollHeight;
          } catch (e) {}
          
          // Call our comprehensive scroll function for both admin/user interfaces
          forceScrollToBottom();
          
          // Schedule additional scroll attempts with increasing delays
          // to handle delayed content rendering or slow resources
          setTimeout(forceScrollToBottom, 200);
          setTimeout(forceScrollToBottom, 500);
          setTimeout(forceScrollToBottom, 1000);
          setTimeout(forceScrollToBottom, 2000);
        } else {
          const lastMsg = messagesElement.find(
            messagesElement.find(".message-card")[0]
          );
          const curOffset =
            lastMsg.offset().top - messagesContainer.scrollTop();
          messagesElement.prepend(data.messages);
          messagesContainer.scrollTop(lastMsg.offset().top - curOffset);
        }
        
        // trigger seen event
        makeSeen(true);
        // Pagination lock & messages page
        noMoreMessages = messagesPage >= data?.last_page;
        if (!noMoreMessages) messagesPage += 1;
        // Enable message form if messenger not = 0; means if data is valid
        if (messenger != 0) {
          disableOnLoad(false);
        }
      },
      error: (error) => {
        setMessagesLoading(false);
        console.error(error);
      },
    });
  }
}

/**
 *-------------------------------------------------------------
 * Cancel file attached in the message.
 *-------------------------------------------------------------
 */
function cancelAttachment() {
  $(".messenger-sendCard").find(".attachment-preview").remove();
  $(".upload-attachment").replaceWith(
    $(".upload-attachment").val("").clone(true)
  );
}

/**
 *-------------------------------------------------------------
 * Cancel updating avatar in settings
 *-------------------------------------------------------------
 */
function cancelUpdatingAvatar() {
  $(".upload-avatar-preview").css("background-image", defaultAvatarInSettings);
  $(".upload-avatar").replaceWith($(".upload-avatar").val("").clone(true));
}

/**
 *-------------------------------------------------------------
 * Pusher channels and event listening..
 *-------------------------------------------------------------
 */

// Listen for messages, and append if needed
function listenForNewMessages() {
  // Get the active conversation ID
  const msgId = getMessengerId();
  if (!msgId) return;

  const channelName = `private-chatify.${msgId}`;
  
  // Unsubscribe from previous channel if exists
  if (pusherChannels[channelName]) {
    try {
      window.pusher.unsubscribe(channelName);
    } catch (e) {
      console.warn("Error unsubscribing from channel:", e);
    }
  }
  
  // Subscribe to the channel
  try {
    const channel = window.pusher.subscribe(channelName);
    pusherChannels[channelName] = channel;
    
    channel.bind("messaging", function (data) {
      console.log("New message received via Pusher:", data);
      
      // Check if the message is for the current conversation
      if (data.from_id == getMessengerId() || data.to_id == getMessengerId()) {
        if (data.to_id == auth_id) {
          playNotificationSound("new_message");
          
          // Check if the message is already in the list
          const messageExists = $(`[data-id="${data.id}"]`).length > 0;
          if (!messageExists) {
            data.created_at = new Date().toISOString();
            
            // Append the message
            messagesContainer.find(".messages").append(data.message_d);
            
            // Add receiving animation to the new message
            const $newMsg = messagesContainer.find(`.message-card[data-id="${data.id}"]`);
            $newMsg.addClass('message-new-received');
            
            console.log("New message appended - forcing scroll");
            
            // Use direct DOM method for immediate effect
            try {
              if (messagesContainer && messagesContainer.length) {
                messagesContainer[0].scrollTop = messagesContainer[0].scrollHeight;
              }
            } catch (e) {}
            
            // Use our comprehensive scroll function that works for all interfaces
            forceScrollToBottom();
            
            // Multiple attempts with delays to ensure it works
            setTimeout(forceScrollToBottom, 200);
            setTimeout(forceScrollToBottom, 500);
            setTimeout(() => {
              forceScrollToBottom();
              // Remove the animation class after animation completes
              $newMsg.removeClass('message-new-received');
            }, 1000);
          }
        }
      }
    });
    
    // Listen for typing indicator
    channel.bind("client-typing", function (data) {
      if (data.from_id != auth_id) {
        data.typing ? showTyping() : hideTyping();
      }
    });
    
    channel.bind("subscription_error", function(error) {
      console.error("Pusher subscription error:", error);
      setTimeout(() => {
        listenForNewMessages();
      }, 5000);
    });
    
    console.log(`Subscribed to channel: ${channelName}`);
  } catch (e) {
    console.error("Error in listenForNewMessages:", e);
  }
}

// Monitor Pusher connection status
setInterval(() => {
  if (window.pusher && window.pusher.connection.state !== "connected") {
    console.log("Pusher reconnecting...");
    window.pusher.connect();
  }
}, 30000);

/**
 *-------------------------------------------------------------
 * Trigger typing event
 *-------------------------------------------------------------
 */
function isTyping(status) {
  return clientSendChannel.trigger("client-typing", {
    from_id: auth_id, // Me
    to_id: getMessengerId(), // Messenger
    typing: status,
  });
}

/**
 *-------------------------------------------------------------
 * Trigger seen event
 *-------------------------------------------------------------
 */
function makeSeen(status) {
  if (document?.hidden) {
    return;
  }
  // remove unseen counter for the user from the contacts list
  $(".messenger-list-item[data-contact=" + getMessengerId() + "]")
    .find("tr>td>b")
    .remove();
  // seen
  $.ajax({
    url: url + "/makeSeen",
    method: "POST",
    data: { _token: csrfToken, id: getMessengerId() },
    dataType: "JSON",
  });
  return clientSendChannel.trigger("client-seen", {
    from_id: auth_id, // Me
    to_id: getMessengerId(), // Messenger
    seen: status,
  });
}

/**
 *-------------------------------------------------------------
 * Trigger contact item updates
 *-------------------------------------------------------------
 */
function sendContactItemUpdates(status) {
  return clientSendChannel.trigger("client-contactItem", {
    from: auth_id, // Me
    to: getMessengerId(), // Messenger
    update: status,
  });
}

/**
 *-------------------------------------------------------------
 * Trigger message delete
 *-------------------------------------------------------------
 */
function sendMessageDeleteEvent(messageId) {
  return clientSendChannel.trigger("client-messageDelete", {
    id: messageId,
  });
}
/**
 *-------------------------------------------------------------
 * Trigger delete conversation
 *-------------------------------------------------------------
 */
function sendDeleteConversationEvent() {
  return clientSendChannel.trigger("client-deleteConversation", {
    from: auth_id,
    to: getMessengerId(),
  });
}

/**
 *-------------------------------------------------------------
 * Check internet connection using pusher states
 *-------------------------------------------------------------
 */
function checkInternet(state, selector) {
  let net_errs = 0;
  const messengerTitle = $(".messenger-headTitle");
  switch (state) {
    case "connected":
      if (net_errs < 1) {
        messengerTitle.text(messengerTitleDefault);
        selector.addClass("successBG-rgba");
        selector.find("span").hide();
        selector.slideDown("fast", function () {
          selector.find(".ic-connected").show();
        });
        setTimeout(function () {
          $(".internet-connection").slideUp("fast");
        }, 3000);
      }
      break;
    case "connecting":
      messengerTitle.text($(".ic-connecting").text());
      selector.removeClass("successBG-rgba");
      selector.find("span").hide();
      selector.slideDown("fast", function () {
        selector.find(".ic-connecting").show();
      });
      net_errs = 1;
      break;
    // Not connected
    default:
      messengerTitle.text($(".ic-noInternet").text());
      selector.removeClass("successBG-rgba");
      selector.find("span").hide();
      selector.slideDown("fast", function () {
        selector.find(".ic-noInternet").show();
      });
      net_errs = 1;
      break;
  }
}

/**
 *-------------------------------------------------------------
 * Get contacts
 *-------------------------------------------------------------
 */
let contactsPage = 1;
let contactsLoading = false;
let noMoreContacts = false;
function setContactsLoading(loading = false) {
  if (!loading) {
    $(".listOfContacts").find(".loading-contacts").remove();
  } else {
    $(".listOfContacts").append(
      `<div class="loading-contacts">${listItemLoading(4)}</div>`
    );
  }
  contactsLoading = loading;
}
function getContacts() {
  if (!contactsLoading && !noMoreContacts) {
    setContactsLoading(true);
    $.ajax({
      url: url + "/getContacts",
      method: "GET",
      data: { _token: csrfToken, page: contactsPage },
      dataType: "JSON",
      success: (data) => {
        setContactsLoading(false);
        if (contactsPage < 2) {
          $(".listOfContacts").html(data.contacts);
        } else {
          $(".listOfContacts").append(data.contacts);
        }
        updateSelectedContact();
        // update data-action required with [responsive design]
        cssMediaQueries();
        // Pagination lock & messages page
        noMoreContacts = contactsPage >= data?.last_page;
        if (!noMoreContacts) contactsPage += 1;
      },
      error: (error) => {
        setContactsLoading(false);
        console.error(error);
      },
    });
  }
}

/**
 *-------------------------------------------------------------
 * Update contact item
 *-------------------------------------------------------------
 */
function updateContactItem(user_id) {
  if (user_id != auth_id) {
    $.ajax({
      url: url + "/updateContacts",
      method: "POST",
      data: {
        _token: csrfToken,
        user_id,
      },
      dataType: "JSON",
      success: (data) => {
        $(".listOfContacts")
          .find(".messenger-list-item[data-contact=" + user_id + "]")
          .remove();
        if (data.contactItem) $(".listOfContacts").prepend(data.contactItem);
        if (user_id == getMessengerId()) updateSelectedContact(user_id);
        // show/hide message hint (empty state message)
        const totalContacts =
          $(".listOfContacts").find(".messenger-list-item")?.length || 0;
        if (totalContacts > 0) {
          $(".listOfContacts").find(".message-hint").hide();
        } else {
          $(".listOfContacts").find(".message-hint").show();
        }
        // update data-action required with [responsive design]
        cssMediaQueries();
      },
      error: (error) => {
        console.error(error);
      },
    });
  }
}

/**
 *-------------------------------------------------------------
 * Star
 *-------------------------------------------------------------
 */

function star(user_id) {
  if (getMessengerId() != auth_id) {
    $.ajax({
      url: url + "/star",
      method: "POST",
      data: { _token: csrfToken, user_id: user_id },
      dataType: "JSON",
      success: (data) => {
        data.status > 0
          ? $(".add-to-favorite").addClass("favorite")
          : $(".add-to-favorite").removeClass("favorite");
      },
      error: () => {
        console.error("Server error, check your response");
      },
    });
  }
}

/**
 *-------------------------------------------------------------
 * Get favorite list
 *-------------------------------------------------------------
 */
function getFavoritesList() {
  $(".messenger-favorites").html(avatarLoading(4));
  $.ajax({
    url: url + "/favorites",
    method: "POST",
    data: { _token: csrfToken },
    dataType: "JSON",
    success: (data) => {
      if (data.count > 0) {
        $(".favorites-section").show();
        $(".messenger-favorites").html(data.favorites);
      } else {
        $(".favorites-section").hide();
      }
      // update data-action required with [responsive design]
      cssMediaQueries();
    },
    error: () => {
      console.error("Server error, check your response");
    },
  });
}

/**
 *-------------------------------------------------------------
 * Get shared photos
 *-------------------------------------------------------------
 */
function getSharedPhotos(user_id) {
  $.ajax({
    url: url + "/shared",
    method: "POST",
    data: { _token: csrfToken, user_id: user_id },
    dataType: "JSON",
    success: (data) => {
      $(".shared-photos-list").html(data.shared);
    },
    error: () => {
      console.error("Server error, check your response");
    },
  });
}

/**
 *-------------------------------------------------------------
 * Search in messenger
 *-------------------------------------------------------------
 */
let searchPage = 1;
let noMoreDataSearch = false;
let searchLoading = false;
let searchTempVal = "";
function setSearchLoading(loading = false) {
  if (!loading) {
    $(".search-records").find(".loading-search").remove();
  } else {
    $(".search-records").append(
      `<div class="loading-search">${listItemLoading(4)}</div>`
    );
  }
  searchLoading = loading;
}
function messengerSearch(input) {
  if (input != searchTempVal) {
    searchPage = 1;
    noMoreDataSearch = false;
    searchLoading = false;
  }
  searchTempVal = input;
  if (!searchLoading && !noMoreDataSearch) {
    if (searchPage < 2) {
      $(".search-records").html("");
    }
    setSearchLoading(true);
    $.ajax({
      url: url + "/search",
      method: "GET",
      data: { _token: csrfToken, input: input, page: searchPage },
      dataType: "JSON",
      success: (data) => {
        setSearchLoading(false);
        if (searchPage < 2) {
          $(".search-records").html(data.records);
        } else {
          $(".search-records").append(data.records);
        }
        // update data-action required with [responsive design]
        cssMediaQueries();
        // Pagination lock & messages page
        noMoreDataSearch = searchPage >= data?.last_page;
        if (!noMoreDataSearch) searchPage += 1;
      },
      error: (error) => {
        setSearchLoading(false);
        console.error(error);
      },
    });
  }
}

/**
 *-------------------------------------------------------------
 * Delete Conversation
 *-------------------------------------------------------------
 */
function deleteConversation(id) {
  $.ajax({
    url: url + "/deleteConversation",
    method: "POST",
    data: { _token: csrfToken, id: id },
    dataType: "JSON",
    beforeSend: () => {
      // hide delete modal
      app_modal({
        show: false,
        name: "delete",
      });
      // Show waiting alert modal
      app_modal({
        show: true,
        name: "alert",
        buttons: false,
        body: loadingSVG("32px", null, "margin:auto"),
      });
    },
    success: (data) => {
      // delete contact from the list
      $(".listOfContacts")
        .find(".messenger-list-item[data-contact=" + id + "]")
        .remove();
      // refresh info
      IDinfo(id);

      if (!data.deleted)
        return alert("Error occurred, messages can not be deleted!");

      // Hide waiting alert modal
      app_modal({
        show: false,
        name: "alert",
        buttons: true,
        body: "",
      });

      sendDeleteConversationEvent();

      // update contact list item
      sendContactItemUpdates(true);
    },
    error: () => {
      console.error("Server error, check your response");
    },
  });
}

/**
 *-------------------------------------------------------------
 * Delete Message By ID
 *-------------------------------------------------------------
 */
function deleteMessage(id) {
  $.ajax({
    url: url + "/deleteMessage",
    method: "POST",
    data: { _token: csrfToken, id: id },
    dataType: "JSON",
    beforeSend: () => {
      // hide delete modal
      app_modal({
        show: false,
        name: "delete",
      });
      // Show waiting alert modal
      app_modal({
        show: true,
        name: "alert",
        buttons: false,
        body: loadingSVG("32px", null, "margin:auto"),
      });
    },
    success: (data) => {
      $(".messages").find(`.message-card[data-id=${id}]`).remove();
      if (!data.deleted)
        console.error("Error occurred, message can not be deleted!");

      sendMessageDeleteEvent(id);

      // Hide waiting alert modal
      app_modal({
        show: false,
        name: "alert",
        buttons: true,
        body: "",
      });
    },
    error: () => {
      console.error("Server error, check your response");
    },
  });
}

/**
 *-------------------------------------------------------------
 * Update Settings
 *-------------------------------------------------------------
 */
function updateSettings() {
  const formData = new FormData($("#update-settings")[0]);
  if (messengerColor) {
    formData.append("messengerColor", messengerColor);
  }
  if (dark_mode) {
    formData.append("dark_mode", dark_mode);
  }
  $.ajax({
    url: url + "/updateSettings",
    method: "POST",
    data: formData,
    dataType: "JSON",
    processData: false,
    contentType: false,
    beforeSend: () => {
      // close settings modal
      app_modal({
        show: false,
        name: "settings",
      });
      // Show waiting alert modal
      app_modal({
        show: true,
        name: "alert",
        buttons: false,
        body: loadingSVG("32px", null, "margin:auto"),
      });
    },
    success: (data) => {
      if (data.error) {
        // Show error message in alert modal
        app_modal({
          show: true,
          name: "alert",
          buttons: true,
          body: data.msg,
        });
      } else {
        // Hide alert modal
        app_modal({
          show: false,
          name: "alert",
          buttons: true,
          body: "",
        });

        // reload the page
        location.reload(true);
      }
    },
    error: () => {
      console.error("Server error, check your response");
    },
  });
}

/**
 *-------------------------------------------------------------
 * Set Active status
 *-------------------------------------------------------------
 */
function setActiveStatus(status) {
  $.ajax({
    url: url + "/setActiveStatus",
    method: "POST",
    data: { _token: csrfToken, status: status },
    dataType: "JSON",
    success: (data) => {
      // Nothing to do
    },
    error: () => {
      console.error("Server error, check your response");
    },
  });
}

/**
 *-------------------------------------------------------------
 * On DOM ready
 *-------------------------------------------------------------
 */
$(document).ready(function () {
  // Add modern styling to the chat interface
  injectModernChatStyles();

  // get contacts list
  getContacts();

  // get contacts list
  getFavoritesList();

  // Clear typing timeout
  clearTimeout(typingTimeout);

  // NProgress configurations
  NProgress.configure({ showSpinner: false, minimum: 0.7, speed: 500 });

  // make message input autosize.
  autosize($(".m-send"));
  
  // Add a scroll to bottom button for both user and admin interfaces
  // This provides a manual fallback when auto-scroll doesn't work
  try {
    // For Chatify user interface
    if ($('.messenger-messagingView').length) {
      if (!$('#scroll-to-bottom-btn').length) {
        $('.messenger-messagingView').append(
          '<button id="scroll-to-bottom-btn" style="position: fixed; bottom: 80px; right: 20px; z-index: 9999; ' +
          'background: #2180f3; color: white; border: none; border-radius: 50%; width: 40px; height: 40px; ' +
          'display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">' +
          '<i class="fas fa-arrow-down"></i></button>'
        );
      }
    }
    
    // For admin interface
    if ($('.chat-messages').length && !$('#scroll-to-bottom-btn').length) {
      $('.chat-messages').parent().append(
        '<button id="scroll-to-bottom-btn" style="position: absolute; bottom: 80px; right: 20px; z-index: 9999; ' +
        'background: #2180f3; color: white; border: none; border-radius: 50%; width: 40px; height: 40px; ' +
        'display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">' +
        '<i class="fas fa-arrow-down"></i></button>'
      );
    }
    
    // Add scroll button click handler
    $(document).on('click', '#scroll-to-bottom-btn', function() {
      console.log("Manual scroll button clicked");
      forceScrollToBottom();
    });
    
    console.log("Added manual scroll button");
  } catch (e) {
    console.error("Error adding scroll button:", e);
  }

  // Force scroll to bottom on page load for all user types (admin and regular users)
  // This ensures messages are visible immediately when opening a conversation
  setTimeout(function() {
    // Call the comprehensive scroll function
    forceScrollToBottom();
    console.log("Initial auto-scroll executed");
  }, 500);
  
  // Schedule additional scroll attempts to handle slow-loading content
  setTimeout(forceScrollToBottom, 1000);
  setTimeout(forceScrollToBottom, 2000);

  // check if pusher has access to the channel [Internet status]
  pusher.connection.bind("state_change", function (states) {
    let selector = $(".internet-connection");
    checkInternet(states.current, selector);
    // listening for pusher:subscription_succeeded
    channel.bind("pusher:subscription_succeeded", function () {
      // On connection state change [Updating] and get [info & msgs]
      if (getMessengerId() != 0) {
        if (
          $(".messenger-list-item")
            .find("tr[data-action]")
            .attr("data-action") == "1"
        ) {
          $(".messenger-listView").hide();
        }
        IDinfo(getMessengerId());
      }
    });
  });

  // tabs on click, show/hide...
  $(".messenger-listView-tabs a").on("click", function () {
    var dataView = $(this).attr("data-view");
    $(".messenger-listView-tabs a").removeClass("active-tab");
    $(this).addClass("active-tab");
    $(".messenger-tab").hide();
    $(".messenger-tab[data-view=" + dataView + "]").show();
  });

  // set item active on click
  $("body").on("click", ".messenger-list-item", function () {
    $(".messenger-list-item").removeClass("m-list-active");
    $(this).addClass("m-list-active");
    const userID = $(this).attr("data-contact");
    routerPush(document.title, `${url}/${userID}`);
    updateSelectedContact(userID);
  });

  // show info side button
  $(".messenger-infoView nav a , .show-infoSide").on("click", function () {
    $(".messenger-infoView").toggle();
  });

  // make favorites card dragable on click to slide.
  hScroller(".messenger-favorites");

  // click action for list item [user/group]
  $("body").on("click", ".messenger-list-item", function () {
    if ($(this).find("tr[data-action]").attr("data-action") == "1") {
      $(".messenger-listView").hide();
    }
    const dataId = $(this).find("p[data-id]").attr("data-id");
    setMessengerId(dataId);
    IDinfo(dataId);
    
    // Add immediate scroll attempt when clicking a conversation
    setTimeout(forceScrollToBottom, 200);
    setTimeout(forceScrollToBottom, 500);
    setTimeout(forceScrollToBottom, 1000);
  });

  // click action for favorite button
  $("body").on("click", ".favorite-list-item", function () {
    if ($(this).find("div").attr("data-action") == "1") {
      $(".messenger-listView").hide();
    }
    const uid = $(this).find("div.avatar").attr("data-id");
    setMessengerId(uid);
    IDinfo(uid);
    updateSelectedContact(uid);
    routerPush(document.title, `${url}/${uid}`);
  });

  // list view buttons
  $(".listView-x").on("click", function () {
    $(".messenger-listView").hide();
  });
  $(".show-listView").on("click", function () {
    routerPush(document.title, `${url}/`);
    $(".messenger-listView").show();
  });

  // click action for [add to favorite] button.
  $(".add-to-favorite").on("click", function () {
    star(getMessengerId());
  });

  // calling Css Media Queries
  cssMediaQueries();

  // message form on submit.
  $("#message-form").on("submit", (e) => {
    e.preventDefault();
    sendMessage();
  });

  // message input on keyup [Enter to send, Enter+Shift for new line]
  $("#message-form .m-send").on("keyup", (e) => {
    // if enter key pressed.
    if (e.which == 13 || e.keyCode == 13) {
      // if shift + enter key pressed, do nothing (new line).
      // if only enter key pressed, send message.
      if (!e.shiftKey) {
        triggered = isTyping(false);
        sendMessage();
      }
    }
  });

  // On [upload attachment] input change, show a preview of the image/file.
  $("body").on("change", ".upload-attachment", (e) => {
    let file = e.target.files[0];
    if (!attachmentValidate(file)) return false;
    let reader = new FileReader();
    let sendCard = $(".messenger-sendCard");
    reader.readAsDataURL(file);
    reader.addEventListener("loadstart", (e) => {
      $("#message-form").before(loadingSVG());
    });
    reader.addEventListener("load", (e) => {
      $(".messenger-sendCard").find(".loadingSVG").remove();
      if (!file.type.match("image.*")) {
        // if the file not image
        sendCard.find(".attachment-preview").remove(); // older one
        sendCard.prepend(attachmentTemplate("file", file.name));
      } else {
        // if the file is an image
        sendCard.find(".attachment-preview").remove(); // older one
        sendCard.prepend(
          attachmentTemplate("image", file.name, e.target.result)
        );
      }
    });
  });

  function attachmentValidate(file) {
    const fileElement = $(".upload-attachment");
    const { name: fileName, size: fileSize } = file;
    const fileExtension = fileName.split(".").pop();
    if (
      !chatify.allAllowedExtensions.includes(
        fileExtension.toString().toLowerCase()
      )
    ) {
      alert("file type not allowed");
      fileElement.val("");
      return false;
    }
    // Validate file size.
    if (fileSize > chatify.maxUploadSize) {
      alert("File is too large!");
      return false;
    }
    return true;
  }

  // Attachment preview cancel button.
  $("body").on("click", ".attachment-preview .cancel", () => {
    cancelAttachment();
  });

  // typing indicator on [input] keyDown
  $("#message-form .m-send").on("keydown", () => {
    if (typingNow < 1) {
      isTyping(true);
      typingNow = 1;
    }
    clearTimeout(typingTimeout);
    typingTimeout = setTimeout(function () {
      isTyping(false);
      typingNow = 0;
    }, 1000);
  });

  // Image modal
  $("body").on("click", ".chat-image", function () {
    let src = $(this).css("background-image").split(/"/)[1];
    $("#imageModalBox").show();
    $("#imageModalBoxSrc").attr("src", src);
  });
  $(".imageModal-close").on("click", function () {
    $("#imageModalBox").hide();
  });

  // Search input on focus
  $(".messenger-search").on("focus", function () {
    $(".messenger-tab").hide();
    $('.messenger-tab[data-view="search"]').show();
  });
  $(".messenger-search").on("blur", function () {
    setTimeout(function () {
      $(".messenger-tab").hide();
      $('.messenger-tab[data-view="users"]').show();
    }, 200);
  });
  // Search action on keyup
  const debouncedSearch = debounce(function () {
    const value = $(".messenger-search").val();
    messengerSearch(value);
  }, 500);
  $(".messenger-search").on("keyup", function (e) {
    const value = $(this).val();
    if ($.trim(value).length > 0) {
      $(".messenger-search").trigger("focus");
      debouncedSearch();
    } else {
      $(".messenger-tab").hide();
      $('.messenger-listView-tabs a[data-view="users"]').trigger("click");
    }
  });

  // Delete Conversation button
  $(".messenger-infoView-btns .delete-conversation").on("click", function () {
    app_modal({
      name: "delete",
    });
  });
  // Delete Message Button
  $("body").on("click", ".message-card .actions .delete-btn", function () {
    app_modal({
      name: "delete",
      data: $(this).data("id"),
    });
  });
  // Delete modal [on delete button click]
  $(".app-modal[data-name=delete]")
    .find(".app-modal-footer .delete")
    .on("click", function () {
      const id = $("body")
        .find(".app-modal[data-name=delete]")
        .find(".app-modal-card")
        .attr("data-modal");
      if (id == 0) {
        deleteConversation(getMessengerId());
      } else {
        deleteMessage(id);
      }
      app_modal({
        show: false,
        name: "delete",
      });
    });
  // delete modal [cancel button]
  $(".app-modal[data-name=delete]")
    .find(".app-modal-footer .cancel")
    .on("click", function () {
      app_modal({
        show: false,
        name: "delete",
      });
    });

  // Settings button action to show settings modal
  $("body").on("click", ".settings-btn", function (e) {
    e.preventDefault();
    app_modal({
      show: true,
      name: "settings",
    });
  });

  // on submit settings' form
  $("#update-settings").on("submit", (e) => {
    e.preventDefault();
    updateSettings();
  });
  // Settings modal [cancel button]
  $(".app-modal[data-name=settings]")
    .find(".app-modal-footer .cancel")
    .on("click", function () {
      app_modal({
        show: false,
        name: "settings",
      });
      cancelUpdatingAvatar();
    });
  // upload avatar on change
  $("body").on("change", ".upload-avatar", (e) => {
    // store the original avatar
    if (defaultAvatarInSettings == null) {
      defaultAvatarInSettings = $(".upload-avatar-preview").css(
        "background-image"
      );
    }
    let file = e.target.files[0];
    if (!attachmentValidate(file)) return false;
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.addEventListener("loadstart", (e) => {
      $(".upload-avatar-preview").append(
        loadingSVG("42px", "upload-avatar-loading")
      );
    });
    reader.addEventListener("load", (e) => {
      $(".upload-avatar-preview").find(".loadingSVG").remove();
      if (!file.type.match("image.*")) {
        // if the file is not an image
        console.error("File you selected is not an image!");
      } else {
        // if the file is an image
        $(".upload-avatar-preview").css(
          "background-image",
          'url("' + e.target.result + '")'
        );
      }
    });
  });
  // change messenger color button
  $("body").on("click", ".update-messengerColor .color-btn", function () {
    messengerColor = $(this).attr("data-color");
    $(".update-messengerColor .color-btn").removeClass("m-color-active");
    $(this).addClass("m-color-active");
  });
  // Switch to Dark/Light mode
  $("body").on("click", ".dark-mode-switch", function () {
    if ($(this).attr("data-mode") == "0") {
      $(this).attr("data-mode", "1");
      $(this).removeClass("far");
      $(this).addClass("fas");
      dark_mode = "dark";
    } else {
      $(this).attr("data-mode", "0");
      $(this).removeClass("fas");
      $(this).addClass("far");
      dark_mode = "light";
    }
  });

  //Messages pagination
  actionOnScroll(
    ".m-body.messages-container",
    function () {
      fetchMessages(getMessengerId());
    },
    true
  );
  //Contacts pagination
  actionOnScroll(".messenger-tab.users-tab", function () {
    getContacts();
  });
  //Search pagination
  actionOnScroll(".messenger-tab.search-tab", function () {
    messengerSearch($(".messenger-search").val());
  });

  // Add a ping handler to verify Pusher connection
  function setupPingHandler() {
    // Get conversation ID if we're in a conversation
    const messengerId = getMessengerId();
    if (!messengerId) return;
    
    // Set up the channel
    const channelName = `private-chatify.${auth_id}`;
    try {
        // Only subscribe if not already subscribed
        if (!window.pusher.channel(channelName)) {
            const channel = window.pusher.subscribe(channelName);
            
            // Listen for ping events
            channel.bind('ping', function(data) {
                console.log('Ping received:', data);
                
                // This confirms Pusher is working
                if (window.chatifyPingReceived) {
                    clearTimeout(window.chatifyPingReceived);
                }
                
                window.chatifyPingReceived = setTimeout(() => {
                    // Test connection periodically
                    testConnection();
                }, 30000);
            });
            
            // Refresh messenger when ping received to ensure connection is active
            channel.bind('messaging', function(data) {
                // Process the message
                processMessage(data);
            });
        }
    } catch (e) {
        console.error('Error setting up ping handler:', e);
    }
  }

  // Test connection to ensure real-time communication
  function testConnection() {
    $.ajax({
        url: `${url}/testConnection`,
        method: 'POST',
        data: { 
            _token: csrfToken,
            user_id: getMessengerId() 
        },
        dataType: 'JSON',
        success: (data) => {
            console.log('Connection test sent:', data);
        },
        error: (error) => {
            console.error('Error testing connection:', error);
            
            // Attempt to reconnect if error
            if (window.pusher) {
                window.pusher.disconnect();
                setTimeout(() => {
                    window.pusher.connect();
                    setupPingHandler();
                }, 2000);
            }
        }
    });
  }

  // Process incoming message
  function processMessage(data) {
    if (!data) return;
    
    console.log('Processing incoming message:', data);
    
    // Make sure it's for the current conversation
    if (data.to_id == auth_id && data.from_id == getMessengerId()) {
        // Remove the message hint if any
        $('.messages').find('.message-hint').remove();
        
        // Check if this message is already in the DOM
        if ($(`.message-card[data-id="${data.id}"]`).length === 0) {
            // If not, append the message
            $('.messages').append(data.message);
            
            // Scroll to bottom
            scrollToBottom('.messages');
            
            // Mark as seen
            makeSeen(true);
        }
    }
    
    // Play notification sound if not for current chat
    playNotificationSound('new_message', 
        !(data.from_id == getMessengerId() && data.to_id == auth_id));
  }

  // Initialize ping handler when messenger is ready
  $(document).ready(function() {
    // Set up ping handler when page loads
    setTimeout(() => {
        setupPingHandler();
        
        // Send initial test connection
        testConnection();
    }, 2000);
    
    // Set up a periodic connection check
    setInterval(() => {
        if (window.pusher && window.pusher.connection.state !== 'connected') {
            console.log('Connection not active, reconnecting...');
            window.pusher.connect();
            setTimeout(setupPingHandler, 1000);
        }
    }, 30000);
  });

  // Reconnect when page becomes visible
  document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        console.log('Page visible, checking connection...');
        if (window.pusher && window.pusher.connection.state !== 'connected') {
            window.pusher.connect();
            setTimeout(() => {
                setupPingHandler();
                testConnection();
            }, 1000);
        } else {
            testConnection();
        }
    }
  });
});

/**
 *-------------------------------------------------------------
 * Observer on DOM changes
 *-------------------------------------------------------------
 */
let previousMessengerId = getMessengerId();
const observer = new MutationObserver(function (mutations) {
  if (getMessengerId() !== previousMessengerId) {
    previousMessengerId = getMessengerId();
    initClientChannel();
  }
});
const config = { subtree: true, childList: true };

// start listening to changes
observer.observe(document, config);

// stop listening to changes
// observer.disconnect();

/**
 *-------------------------------------------------------------
 * Resize messaging area when resize the viewport.
 * on mobile devices when the keyboard is shown, the viewport
 * height is changed, so we need to resize the messaging area
 * to fit the new height.
 *-------------------------------------------------------------
 */
var resizeTimeout;
window.visualViewport.addEventListener("resize", (e) => {
  clearTimeout(resizeTimeout);
  resizeTimeout = setTimeout(function () {
    const h = e.target.height;
    if (h) {
      $(".messenger-messagingView").css({ height: h + "px" });
    }
  }, 100);
});

/**
 *-------------------------------------------------------------
 * Emoji Picker
 *-------------------------------------------------------------
 */
const emojiButton = document.querySelector(".emoji-button");

const emojiPicker = new EmojiButton({
  theme: messengerTheme,
  autoHide: false,
  position: "top-start",
});

emojiButton.addEventListener("click", (e) => {
  e.preventDefault();
  emojiPicker.togglePicker(emojiButton);
});

emojiPicker.on("emoji", (emoji) => {
  const el = messageInput[0];
  const startPos = el.selectionStart;
  const endPos = el.selectionEnd;
  const value = messageInput.val();
  const newValue =
    value.substring(0, startPos) +
    emoji +
    value.substring(endPos, value.length);
  messageInput.val(newValue);
  el.selectionStart = el.selectionEnd = startPos + emoji.length;
  el.focus();
});

/**
 *-------------------------------------------------------------
 * Notification sounds
 *-------------------------------------------------------------
 */
function playNotificationSound(soundName, condition = false) {
  if ((document.hidden || condition) && chatify.sounds.enabled) {
    const sound = new Audio(
      `/${chatify.sounds.public_path}/${chatify.sounds[soundName]}`
    );
    sound.play();
  }
}
/**
 *-------------------------------------------------------------
 * Update and format dates to time ago.
 *-------------------------------------------------------------
 */
function updateElementsDateToTimeAgo() {
  $(".message-time").each(function () {
    const time = $(this).attr("data-time");
    $(this).find(".time").text(dateStringToTimeAgo(time));
  });
  $(".contact-item-time").each(function () {
    const time = $(this).attr("data-time");
    $(this).text(dateStringToTimeAgo(time));
  });
}
setInterval(() => {
  updateElementsDateToTimeAgo();
}, 60000);

/**
 *-------------------------------------------------------------
 * Inject modern and impressive chat styling
 *-------------------------------------------------------------
 */
function injectModernChatStyles() {
  // Add custom CSS to completely transform the chat interface
  const modernStyles = `
    <style>
      /* Dark Theme Chat Interface */
      :root {
        --dark-bg: #1e222a;
        --dark-secondary: #282d38;
        --dark-accent: #3a7bd5;
        --dark-text: #e9eef2;
        --dark-text-secondary: #9fa8b5;
        --dark-gradient: linear-gradient(135deg, #3a7bd5, #5865f2);
        --dark-border-radius: 16px;
        --dark-shadow: 0 4px 20px rgba(0,0,0,0.25);
        --dark-transition: 0.2s ease;
      }

      /* Dark Mode Overrides */
      body, .messenger, .messenger-messagingView {
        background-color: var(--dark-bg) !important;
        color: var(--dark-text) !important;
      }

      /* Message list container */
      .messenger-messagingView .m-body {
        background-color: var(--dark-bg) !important;
        background-image: none !important;
        padding: 10px !important;
      }

      /* Load earlier messages button */
      .messenger-messagingView .load-more-messages {
        background-color: var(--dark-secondary) !important;
        color: var(--dark-text-secondary) !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 12px !important;
        margin: 10px auto 20px !important;
        display: block !important;
        width: 90% !important;
        max-width: 380px !important;
        font-weight: 500 !important;
        cursor: pointer !important;
        transition: all 0.3s !important;
        opacity: 0.8 !important;
      }

      .messenger-messagingView .load-more-messages:hover {
        background-color: #303540 !important;
        opacity: 1 !important;
      }

      /* Avatar */
      .avatar {
        border-radius: 50% !important;
        text-align: center !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        background-color: #4169e1 !important;
        color: white !important;
        font-weight: bold !important;
        border: none !important;
      }

      /* Message bubble - receiving */
      .message-card:not(.mc-sender) {
        display: flex !important;
        align-items: flex-start !important;
        margin-bottom: 15px !important;
        gap: 12px !important;
      }

      .message-card:not(.mc-sender) .message {
        background-color: var(--dark-secondary) !important;
        color: var(--dark-text) !important;
        border-radius: 16px !important;
        border-bottom-left-radius: 4px !important;
        padding: 10px 15px !important;
        max-width: 80% !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
      }

      /* Message bubble - sending */
      .message-card.mc-sender .message {
        background: var(--dark-gradient) !important;
        border-radius: 16px !important;
        border-bottom-right-radius: 4px !important;
        color: white !important;
      }

      /* Message time */
      .message-time {
        font-size: 11px !important;
        color: var(--dark-text-secondary) !important;
        margin-top: 4px !important;
      }

      /* User information */
      .messenger-infoView {
        background-color: var(--dark-secondary) !important;
        color: var(--dark-text) !important;
        border-left: 1px solid #343a48 !important;
      }

      /* Avatar styling */
      .messenger-list-item .avatar {
        width: 42px !important;
        height: 42px !important;
        font-size: 18px !important;
      }

      /* Sender name */
      .sender-name {
        display: block !important;
        font-weight: 500 !important;
        color: #adbacb !important;
        margin-bottom: 4px !important;
        font-size: 14px !important;
      }

      /* Message input area */
      .messenger-sendCard {
        background-color: var(--dark-bg) !important;
        border-top: 1px solid #343a48 !important;
        padding: 15px !important;
      }

      .messenger-sendCard .m-send {
        background-color: var(--dark-secondary) !important;
        color: var(--dark-text) !important;
        border: none !important;
        border-radius: 24px !important;
        padding: 12px 20px !important;
        height: auto !important;
        min-height: 48px !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
      }

      .messenger-sendCard .m-send:focus {
        background-color: #30343f !important;
        outline: none !important;
      }

      /* Send button */
      .messenger-sendCard button {
        width: 48px !important;
        height: 48px !important;
        border-radius: 50% !important;
        background: var(--dark-gradient) !important;
        color: white !important;
        margin-left: 10px !important;
        box-shadow: 0 4px 10px rgba(58, 123, 213, 0.3) !important;
        transition: transform 0.2s !important;
      }

      .messenger-sendCard button:hover {
        transform: scale(1.05) !important;
      }

      .messenger-sendCard button:active {
        transform: scale(0.95) !important;
      }

      /* Typing indicator */
      .message-card.typing {
        padding: 10px !important;
        background-color: var(--dark-secondary) !important;
        border-radius: 16px !important;
        height: auto !important; 
        display: inline-flex !important;
        width: auto !important;
      }

      .message-card.typing .dot {
        background-color: var(--dark-text) !important;
      }

      /* Attachment button */
      .upload-attachment {
        color: var(--dark-text-secondary) !important;
      }

      /* Scroll to bottom button */
      #scroll-to-bottom-btn {
        background: var(--dark-gradient) !important;
        box-shadow: 0 4px 15px rgba(58, 123, 213, 0.4) !important;
      }
    </style>
  `;
  
  $('head').append(modernStyles);
  
  // Make sure elements have proper classes for dark mode styling
  $('.messenger-sendCard').each(function() {
    if (!$(this).find('.send-button').length) {
      $(this).find('button').addClass('send-button').html('<i class="fas fa-paper-plane"></i>');
    }
  });
  
  // Update load earlier messages button styling
  $('.messenger-messagingView').find('button:contains("Load earlier messages")').addClass('load-more-messages');
  
  // Add animated typing indicator
  const typingAnimations = `
    <style>
      .message-card.typing .typing-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 5px;
      }
      
      .message-card.typing .dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--dark-text);
        animation: typingAnimation 1.4s infinite ease-in-out both;
        margin: 0 2px;
      }

      .message-card.typing .dot:nth-child(1) {
        animation-delay: 0s;
      }

      .message-card.typing .dot:nth-child(2) {
        animation-delay: 0.2s;
      }

      .message-card.typing .dot:nth-child(3) {
        animation-delay: 0.4s;
      }

      @keyframes typingAnimation {
        0%, 80%, 100% { transform: scale(0.7); opacity: 0.5; }
        40% { transform: scale(1); opacity: 1; }
      }
    </style>
  `;
  
  $('head').append(typingAnimations);
  
  // Transform username display for received messages
  $('.message-card:not(.mc-sender)').each(function() {
    const message = $(this).find('.message');
    if (message.length && !$(this).find('.sender-name').length) {
      const senderName = $(this).closest('.message-card').attr('data-sender') || 'User';
      message.prepend(`<span class="sender-name">${senderName}</span>`);
    }
  });
  
  // Override template for received message cards to show avatar and name
  window.originalTemplateMessage = window.templateMessage;
  window.templateMessage = function(message, id) {
    return `
      <div class="message-card" data-id="${id}">
        <div class="avatar">
          ${message.from_initial || 'U'}
        </div>
        <div class="message-card-content">
          <div class="message">
            <span class="sender-name">${message.from_name || 'User'}</span>
            ${message.body}
            <div class="message-time">
              <span>${message.created_at}</span>
            </div>
          </div>
        </div>
      </div>
    `;
  };
  
  console.log("Dark theme chat styling applied");
}
