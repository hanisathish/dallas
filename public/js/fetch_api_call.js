function fetchDataApi(props, callback) {
    let payload = {};
    if (props.method == 'post') {
        payload = {
            method: props.method,
            body: props.method === 'post' ? JSON.stringify(props.queryData) : ''
        }
    }
    payload.headers = {
        'Content-Type': 'application/json',
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    }
    fetch(props.url, payload).then(
        function (response) {
            if (response.status !== 200) {
                throw new Error("failure with error code" + response.status)
            }
            response.json().then(function (data) {
                return callback(data);
            });
        }).catch(function (err) {
            console.log('Fetch Error :-S', err);
        });
}