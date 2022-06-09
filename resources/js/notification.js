import Pusher from "pusher-js";
import trans from "./trans";

var pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
    encrypted: true,
    cluster: "ap1",
});

var channel = pusher.subscribe("channel-notificationstatus-" + window.user);
channel.bind("notificationstatus-event", async function (data) {
    let quantity = parseInt($(".notification").find(".noti").html());
    
    if (Number.isNaN(quantity)) {
        $(".noti-num").append(
            '<span class="noti" id="noti-quantity">1</span>'
        );
    }  else {
        $("#noti-quantity")
            .html(quantity + 1);
    }

    var status = '';
    switch (data.status) {
        case '1':
            status = trans('me.Pendding');
            break;
        case '2':
            status = trans('me.Processing');
            break;
        case '3':
            status = trans('me.Delivering');
            break;
        case '4':
            status = trans('me.Complete');
            break;
        case '5':
            status = trans('me.noti_cancel');
            break;
        case '6':
            status = trans('me.Rejected');
            break;
    }

    let notificationBox = `
        <a class="dropdown-item dropdown-item-underline }}" href="{{ route('users.read.noti', $item->id) }}">
            <div class="read">
                Your order <strong>`+ status +`</strong>
                <br>
                <small class="box read">${ trans('me.recent') }</small>
            </div>
        </a>
    `;

    $('.notification-list').prepend(notificationBox);
});
