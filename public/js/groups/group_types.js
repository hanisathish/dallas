let queries = null;
let selectedGType = null;
$(document).ready(function () {
    // $(".container-fluid").addClass("m-0 p-0");
    // $(".container-fluid").css({ width: "100vw" });
    // $("#navigation .navigation-menu").addClass("pl-3");
    // $(".wrapper").css("padding-top", "118px");
    queries = getQueries();
    console.log("Queries :", queries)
    selectedGType = queries.groupType ? queries.groupType : null;
    fetchGroupTypes();
});

function fetchGroupTypes() {
    let apiPath = siteUrl + '/api/groups/typesList';
    let queryData = {};
    let apiProps = { url: apiPath, method: 'get', queryData };
    fetchDataApi(apiProps, function (data) {
        if (!selectedGType) {
            selectedGType = data[0].id;
            queries.groupType = selectedGType;
            updateQueryString(queries);
        }
        updateSelectInput(data);
        updateTabUrlLinks();
    });
}

function updateSelectInput(data) {
    let optEls = data.map(function (item) { return `<option value="${item.id}" ${selectedGType == item.id ? "selected" : ""}>${item.name}</option>`; });
    let selectEl = `<select name="${selectedGType}" onChange="gTypeChanged()" id="gTypeSelectEl" class="select select--group-type custom-select">${optEls}<hr/><option value="all" ${selectedGType == "all" ? "selected" : ""}>All</option></select>`;
    $("#gTypeSelectEl").val(selectedGType);
    $('.grpTypeSelect').html(selectEl);
}

function gTypeChanged() {
    selectedGType = $("#gTypeSelectEl").val();
    queries.groupType = selectedGType;
    updateQueryString(queries);
    updateTabUrlLinks();
    listGroups(selectedGType);
}

function updateTabUrlLinks() {
    //let pathNames = [{ path: '/groups', title: "Groups" }, { path: '/groups/reports', title: "Reports" }, { path: '/groups/events', title: "Events" }, { path: '/groups/resources', title: "Resources" }];
    let pathNames = [{ path: '/groups', title: "Groups" }];
    let querySring = generateQueryString(queries);

    let tabEls = pathNames.map(function (item) {
        let activeClass = location.pathname == item.path ? 'bg-secondary active' : '';
        return `<li class="nav-item"><strong><a class="btn nav-link text-white ${activeClass}" href="${siteUrl + item.path + querySring}">${item.title}</a></strong></li>`
    });

    $(".groupsUrlTabs").html(tabEls);
}
