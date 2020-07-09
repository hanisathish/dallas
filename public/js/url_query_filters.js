function getQueries() {
    console.log("initial query string", window.location.search)
    if (window.location.search) {
        let queries = decodeURI(window.location.search)
            .replace('?', '')
            .split('&')
            .map(param => param.split('='))
            .reduce((values, [key, value]) => {
                value = value[value.length - 1] === "#" ? value.substr(0, value.length - 2) : value;
                values[key] = value
                return values
            }, {});
        return queries;
    } else {
        return {};
    }

}

function updateQueryString(queryObj) {
    let queryString = generateQueryString(queryObj);
    let newUri = location.href.split("?")[0] + queryString;
    window.history.pushState({ path: newUri }, '', newUri);
}

function generateQueryString(queryObj) {
    let queryString = "?";
    Object.keys(queryObj).forEach(function (key) {
        queryString += key + "=" + queryObj[key] + "&";
    });
    if (queryString[queryString.length - 1] === "&") {
        queryString = queryString.slice(0, -1);
    }
    return queryString;
}