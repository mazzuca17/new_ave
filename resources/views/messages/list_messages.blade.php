<div class="email-list">
    <a href="{{ route('mensajes.show', $item->email->id) }}" class="email-list-item {{ $item->is_read ? '' : 'unread' }}"
        aria-label="Ver mensaje de {{ $item->email->sender->name }}">
        <article class="email-list-detail">
            <span class="date float-right">
                @if ($item->email->attachments->count() > 0)
                    <i class="fa fa-paperclip paperclip" aria-hidden="true"></i>
                @endif
                {{ $item->created_at->format('d M') }}
            </span>
            <span class="from">{{ $item->email->sender->name }}</span>
            <p class="msg mb-0">{{ $item->email->subject }}</p>
        </article>
    </a>
</div>
