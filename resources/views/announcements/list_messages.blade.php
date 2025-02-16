<div class="email-list">
    <div class="email-list">
        <div class="email-list-item {{ $item->is_read ? '' : 'unread' }}">
            <div class="email-list-actions">
                <div class="d-flex">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input"><span class="custom-control-label"></span>
                    </label>
                    <span class="rating rating-sm mr-3">
                        <input type="checkbox" id="star{{ $item->id }}" value="1">
                        <label for="star{{ $item->id }}">
                            <span class="fa fa-star"></span>
                        </label>
                    </span>
                </div>
            </div>
            <div class="email-list-detail">
                <span class="date float-right">
                    @if ($item->files->count() > 0)
                        <i class="fa fa-paperclip paperclip"></i>
                    @endif
                    {{ $item->created_at->format('d M') }}
                </span>
                <span class="from">{{ $item->sender->name }}</span>
                <p class="msg">{{ $item->subject }}</p>
            </div>
        </div>
    </div>


</div>
