<div class="toolbar d-flex justify-content-between">
    <div class="main-options d-flex align-items-center">
        <div class="messageSelect">
            <div class="dropdown d-flex align-items-center">
                <label for="selectInbox" class="custom-checkbox">
                    <input type="checkbox" id="selectInbox">
                    <span></span>
                </label>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="inboxDropdown" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu" aria-labelledby="inboxDropdown">
                    <a class="dropdown-item" href="#" onclick="checkBoxEvent('A')">All</a>
                    <a class="dropdown-item" href="#" onclick="checkBoxEvent('N')">None</a>
                    <a class="dropdown-item" href="#" onclick="checkBoxEvent('R')">Read</a>
                    <a class="dropdown-item" href="#" onclick="checkBoxEvent('U')">Unread</a>
                </div>
            </div>
        </div>
        <div class="messageActions d-none">
            <!-- <a href="#"><span class="icon inbox-refresh"></span></a> -->
            <a href="#" onclick="remove_message('')"><span class="icon inbox-trash"></span></a>
        </div>
        <div class="messageReadUnread">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="readUnread" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="icon vert-options"></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="readUnread">
                    <a class="dropdown-item" href="#" onclick="markMessage('1')">Mark as read</a>
                    <a class="dropdown-item" href="#" onclick="markMessage('0')">Mark as unread</a>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="pagination m-0 d-flex align-items-center">
        <span class="pagination-count"></span>
        <a href="#" onclick="movePagination('P')">
            <span class="icon inbox-prev"></span>
        </a>
        <a href="#" onclick="movePagination('N')">
            <span class="icon inbox-next"></span>
        </a>
    </div> --}}
</div>
<table class="table">
    @if (count($list) > 0)
        @foreach ($list as $row)
            {{ $class = '' }}
            @if ($row->is_read == 0)
                <?php $class = 'font-weight-bold'; ?>
            @endif
            <?php
            $name = '';
            if ($row->first_name == '' || $row->first_name == null) {
                $name = explode('@', $row->email)[0];
            } else {
                $name = $row->first_name . ' ' . $row->last_name;
            }
            ?>
            <tr class="unread">
                <td>
                    <table>
                        <tr id="tr_{{ $row->id }}">
                            <td class="message-checkbox">
                                <label class="custom-checkbox">
                                    <input class="rowCheckbox" type="checkbox" data-id="{{ $row->id }}"
                                        data-check="{{ $row->is_read }}" />
                                    <span></span>
                                </label>
                            </td>
                            <td class='message-from' style="width: 40%;" ;><a class="{{ $class }}"
                                    href="\message\detail\{{ $row->id }}\{{ $row->from_user_id }}">{{ $name }}</a>
                            </td>
                            <td class="message-text"><a class="{{ $class }}"
                                    href="\message\detail\{{ $row->id }}\{{ $row->from_user_id }}">{{ $row->subject }}</a>
                            </td>
                            <td style="width: 5%;display:none;"><span onclick="remove_message('{{ $row->id }}')"
                                    class="icon inbox-trash {{ $class }}    "></span></td>
                            <td class="message-time">{{ date_format($row->created_at, 'H:i A') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td>
                <span>No Messages Found</span>
            </td>
        </tr>

    @endif
    <tfoot>
        <tr>
            <td>

                Showing {{ $list->firstItem() }} to {{ $list->lastItem() }} of total
                {{ $list->total() }} items
                <div class="float-right">
                    {!! $list->links() !!}
                </div>

            </td>
        </tr>
    </tfoot>
</table>
