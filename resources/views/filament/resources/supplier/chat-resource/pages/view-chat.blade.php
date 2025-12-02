<x-filament-panels::page>
    <style>
        .fi-fo-textarea textarea {
            color: #111827 !important;
            background-color: white !important;
        }
        .fi-fo-textarea textarea::placeholder {
            color: #9ca3af !important;
        }
        .messages-container {
            background: linear-gradient(to bottom, #f9fafb, #f3f4f6);
            min-height: 400px;
        }
        .message-bubble {
            word-wrap: break-word;
            word-break: break-word;
        }
        .message-bubble-sent {
            background: linear-gradient(135deg, #32A7E2 0%, #2B96D1 100%);
            box-shadow: 0 2px 8px rgba(50, 167, 226, 0.3);
        }
        .message-bubble-received {
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }
    </style>
    <div class="space-y-6">
        <!-- Chat Header -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">
                        💬 Chat with {{ $this->record->client->name }}
                    </h2>
                    @if($this->record->rfq)
                        <p class="text-sm text-gray-600 mt-2 flex items-center gap-2">
                            <span class="inline-block w-2 h-2 bg-[#6FC242] rounded-full"></span>
                            Related to RFQ: {{ $this->record->rfq->subject }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div class="messages-container rounded-xl shadow-md p-6 border border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#32A7E2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                Messages
            </h3>
            <div id="messages-scroll" class="space-y-4 max-h-[500px] overflow-y-auto px-2" style="scroll-behavior: smooth;">
                @forelse($this->getViewData()['messages'] as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} animate-fade-in">
                        <div class="max-w-[70%] message-bubble {{ $message->sender_id === auth()->id() ? 'message-bubble-sent text-white' : 'message-bubble-received text-gray-900' }} rounded-2xl p-4 shadow-lg">
                            <div class="flex items-center justify-between mb-2 gap-3">
                                <span class="text-sm font-semibold {{ $message->sender_id === auth()->id() ? 'text-white' : 'text-gray-900' }}">
                                    {{ $message->sender_id === auth()->id() ? 'You' : $message->sender->name }}
                                </span>
                                <span class="text-xs {{ $message->sender_id === auth()->id() ? 'text-white opacity-90' : 'text-gray-600' }} whitespace-nowrap">
                                    {{ $message->created_at->format('H:i') }}
                                </span>
                            </div>
                            <p class="text-base {{ $message->sender_id === auth()->id() ? 'text-white' : 'text-gray-800' }} leading-relaxed">{{ $message->body }}</p>
                            @if(!$message->is_read && $message->sender_id !== auth()->id())
                                <div class="mt-2 flex items-center gap-1">
                                    <span class="inline-block w-2 h-2 bg-[#6FC242] rounded-full animate-pulse"></span>
                                    <span class="text-xs text-gray-600">Unread</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg font-medium">No messages yet</p>
                        <p class="text-gray-400 text-sm mt-2">Start the conversation!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Message Form -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#32A7E2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                Send Message
            </h3>
            <x-filament-panels::form wire:submit="sendMessage" class="space-y-4">
                <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200 focus-within:border-[#32A7E2] transition-colors">
                    {{ $this->getForm('messageForm') }}
                </div>
                <div class="flex justify-end">
                    <x-filament::button type="submit" color="primary" class="bg-[#32A7E2] hover:bg-[#2B96D1]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Send Message
                    </x-filament::button>
                </div>
            </x-filament-panels::form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messagesContainer = document.getElementById('messages-scroll');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });
        Livewire.hook('message.processed', () => {
            const messagesContainer = document.getElementById('messages-scroll');
            if (messagesContainer) {
                setTimeout(() => {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 100);
            }
        });
    </script>
</x-filament-panels::page>

