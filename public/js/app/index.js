$(document).ready(function () {
    const baseURL = $("meta[name='baseURL']").attr('content');
    const csrfToken = $("meta[name='csrfToken']").attr('content');
    let currentChannel = null;

    function subscribeToChannel(uniqueId)
    {
        if (currentChannel) {
            pusher.unsubscribe('session.' + currentChannel);
        }
        currentChannel = uniqueId;
        const channel = pusher.subscribe('session.' + uniqueId);

        channel.bind('session-start', function(data) {
            localStorage.setItem('uniqueId', data.uniqueId);
            window.location.href = `${baseURL}/session/${data.uniqueId}/photos`;
        });
    }

    function refreshQR() {
        $(".loading").show();
        $.ajax({
            url: `${baseURL}/generate-qr`,
            method: 'GET',
            success: function(response) {
                $('.qr-container').html(response.qr);
                $(".loading").hide();
                subscribeToChannel(response.uniqueId);
            }
        });
    }

    refreshQR();
    setInterval(refreshQR, 30000);
});
