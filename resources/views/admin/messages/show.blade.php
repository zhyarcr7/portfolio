<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Message Details') }}
            </h2>
            <a href="{{ route('admin.messages.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
                Back to Messages
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold">{{ $message->subject }}</h3>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $message->read ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $message->read ? 'Read' : 'Unread' }}
                            </span>
                        </div>

                        <div class="border-t border-b py-3 border-gray-200 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">From:</p>
                                    <p class="font-medium">{{ $message->name }} ({{ $message->email }})</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Received:</p>
                                    <p>{{ $message->created_at->format('F d, Y \a\t H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="prose max-w-none">
                            <p>{{ $message->message }}</p>
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <div>
                            <a href="mailto:{{ $message->email }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">
                                Reply via Email
                            </a>
                        </div>
                        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this message?')">
                                Delete Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 