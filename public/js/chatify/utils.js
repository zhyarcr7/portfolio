/**
 * changes date string to time ago string.
 * @param dateString - The date string to convert to a time ago string.
 * @returns A string that tells the user how long ago the date was.
 */
function dateStringToTimeAgo(dateString) {
  const now = new Date();
  const date = new Date(dateString);
  const seconds = Math.floor((now - date) / 1000);
  const minutes = Math.floor(seconds / 60);
  const hours = Math.floor(minutes / 60);
  const days = Math.floor(hours / 24);
  const weeks = Math.floor(days / 7);
  if (seconds < 60) {
    return "just now";
  } else if (minutes < 60) {
    return `${minutes}m ago`;
  } else if (hours < 24) {
    return `${hours}h ago`;
  } else if (days < 7) {
    return `${days}d ago`;
  } else {
    return `${weeks}w ago`;
  }
}
/**
 * It returns a function that, when invoked, will wait for a specified amount of time before executing
 * the original function.
 * @param callback - The function to be executed after the delay.
 * @param delay - The amount of time to wait before calling the callback.
 * @returns A function that will call the callback function after a delay.
 */
function debounce(callback, delay) {
  let timerId;
  return function (...args) {
    clearTimeout(timerId);
    timerId = setTimeout(() => {
      callback.apply(this, args);
    }, delay);
  };
}

/**
 *-------------------------------------------------------------
 * Trigger a Notification for new messages
 *-------------------------------------------------------------
 */
function playNotificationSound(soundName, condition = true) {
  if (condition && chatify.sounds.enabled) {
    const sound = new Audio(
      `/${chatify.sounds.public_path}/${chatify.sounds[soundName]}`
    );
    sound.play();
  }
}

/**
 *-------------------------------------------------------------
 * Scroll to bottom on messages container
 *-------------------------------------------------------------
 */
function scrollToBottom(container = ".messages") {
  $(container).stop().animate({
    scrollTop: $(container)[0].scrollHeight
  }, 200);
}

/**
 *-------------------------------------------------------------
 * Slide up or slide down animation delay handler
 *-------------------------------------------------------------
 */
function slideAnimationDelay(element, delay = 500, type = "down") {
  if (type == "down") {
    $(element).hide();
    $(element).delay(delay).slideDown(200);
  } else {
    $(element).delay(delay).slideUp(200);
  }
}

/**
 *-------------------------------------------------------------
 * Check if a variable is empty
 *-------------------------------------------------------------
 */
function isEmpty(value) {
  return value === undefined || value === null || value === "";
}

/**
 *-------------------------------------------------------------
 * Check if an element exists
 *-------------------------------------------------------------
 */
function elementExists(element) {
  return $(element).length > 0;
}

/**
 *-------------------------------------------------------------
 * Check if an element is visible
 *-------------------------------------------------------------
 */
function elementVisible(element) {
  return $(element).is(":visible");
}

/**
 *-------------------------------------------------------------
 * Error message
 *-------------------------------------------------------------
 */
function errorMessageHandler(element, message) {
  $(element).text(message);
  slideAnimationDelay(element);
}

/**
 *-------------------------------------------------------------
 * Showing typing indicator
 *-------------------------------------------------------------
 */
function showTyping() {
  if (!elementExists(".typing-indicator")) {
    $(".messages").append('<div class="typing-indicator"></div>');
    scrollToBottom();
  }
}

/**
 *-------------------------------------------------------------
 * Hide typing indicator
 *-------------------------------------------------------------
 */
function hideTyping() {
  if (elementExists(".typing-indicator")) {
    $(".typing-indicator").remove();
  }
}

/**
 *-------------------------------------------------------------
 * Process new message in real-time 
 *-------------------------------------------------------------
 */
function processNewMessage(message) {
  // Check if message already exists to avoid duplicates
  if (elementExists(`[data-id="${message.id}"]`)) {
    return false;
  }
  
  // Remove the message hint if there's no messages
  if (elementExists(".message-hint")) {
    $(".message-hint").remove();
  }
  
  // Append the message
  $(".messages").append(message.content);
  
  // Update message indicators
  updateMessageStatus(message.id);
  
  // Scroll to bottom
  scrollToBottom();
  
  // Play notification sound
  playNotificationSound("new_message");
  
  return true;
}

/**
 *-------------------------------------------------------------
 * Update message status (seen, delivered)
 *-------------------------------------------------------------
 */
function updateMessageStatus(messageId) {
  const messageElement = $(`[data-id="${messageId}"]`);
  
  // If the message is not found, return
  if (!messageElement.length) {
    return;
  }
  
  // Mark message as seen
  const statusIcon = messageElement.find(".message-time .fa-check");
  if (statusIcon.length) {
    statusIcon.removeClass("fa-check").addClass("fa-check-double seen");
  }
}

/**
 *-------------------------------------------------------------
 * Re-establish Pusher connection
 *-------------------------------------------------------------
 */
function reconnectPusher() {
  // If window.pusher is not defined, initialize it
  if (typeof window.pusher === 'undefined') {
    if (typeof initPusher === 'function') {
      initPusher();
    }
    return;
  }
  
  // If pusher is defined but disconnected, reconnect
  if (window.pusher.connection.state !== 'connected') {
    console.log("Reconnecting to Pusher...");
    window.pusher.connect();
  }
  
  // Re-subscribe to active conversation if needed
  if (typeof subscribeToActiveChannels === 'function') {
    subscribeToActiveChannels();
  }
}
