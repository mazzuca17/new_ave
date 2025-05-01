<div class="email-list">
    <div href="{{ route('mensajes.show', $item->email->id) }}"
        class="email-list-item {{ $item->is_read ? '' : 'unread' }}">
        <div class="email-list-detail">
            <span class="date float-right">
                @if ($item->email->attachments->count() > 0)
                    <i class="fa fa-paperclip paperclip"></i>
                @endif
                {{ $item->created_at->format('d M') }}
            </span>
            <span class="from">{{ $item->email->sender->name }}</span>
            <p class="msg">{{ $item->email->subject }}</p>
        </div>

    </div>
</div>
