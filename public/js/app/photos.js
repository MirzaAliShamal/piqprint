$(document).ready(function () {
    const baseURL = $("meta[name='baseURL']").attr('content');
    const csrfToken = $("meta[name='csrfToken']").attr('content');

    const channel = pusher.subscribe('session.' + uniqueId);

    channel.bind('photo-uploaded', function(data) {
        location.reload(true);
    });
});
