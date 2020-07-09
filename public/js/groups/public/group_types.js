let selectedGType = null;
let org = null;
let groupTypes = null;
let tagGroups = null;
let queryStr = '';
let filterTagIds= [];

document.addEventListener('DOMContentLoaded', function () {
    org = $("#orgObj").attr("data-org");
    org = JSON.parse(org);
    selectedGType = $("#group-type").attr("data-gType") ? $("#group-type").attr("data-gType") : "all";
    fetchGroupTypes();
});

function fetchGroupTypes() {
    let apiPath = siteUrl + '/api/hosting/groups/typesList';
    let queryData = { orgId: org.orgId, group_type: selectedGType };
    let apiProps = { url: apiPath, method: 'post', queryData };
    fetchDataApi(apiProps, function (data) {
        groupTypes = data.groupTypes;
        if (selectedGType === "all") {
            listGroupTypes();
        } else {
            tagGroups = data.tagGroups;
            listGroupsWithFilters();
        }
        updateSelectInput();
    });
}

function updateSelectInput() {
    let optEls = groupTypes.map(function (item) { return `<option value="${item.name.toLowerCase()}" ${selectedGType == item.name.toLowerCase() ? "selected" : ""}>${item.name}</option>`; });
    let selectEl = `<select name="${selectedGType}" onChange="gTypeChanged()" id="gTypeSelectEl" class="select custom-select"><option value="all" ${selectedGType == "all" ? "selected" : ""}>All Groups</option><hr/>${optEls.join("")}</select>`;
    $(".groupsUrlTabs").val(selectedGType);
    $('.groupsUrlTabs').html(selectEl);
}

function listGroupTypes() {
    let groupTypeEls = groupTypes.map(function(item){
                            let itemEl = genBlkEl("col-sm-12 p-3 card pane groupTypeBlkEl");
                            itemEl.css("min-height", "100px");
                            itemEl.attr("data-name", item.name.toLowerCase());
                            let titleEl = `<h5 class="card-titile font-weight-bold"><span class="text-capitalize">${item.name}</span> <span class="badge badge-secondary">${item.groups_count} groups</span></h5>`;
                            let groupBlkEl = `${titleEl}<p class="card-body text-secondary p-1">${item.description? item.description : 'Group description not present'}</p>`
                            return itemEl.html(groupBlkEl);
                        });
    $("#group-list-content").html(groupTypeEls);
    addEventTriggers();
}

function listGroupsWithFilters() {
    let queryInput = getQueryInputEl();
    let tagFilters = getTagFilters();
    console.log(tagFilters)
    $("#group-list-content").html([queryInput, tagFilters]);
}

function gTypeChanged() {
    selectedGType = $("#gTypeSelectEl").val();
    if (selectedGType !== "all") {
        location = `${siteUrl}/${org.orgDomain}/hosting/groups/${selectedGType.toLowerCase()}`;
    } else {
        location = `${siteUrl}/${org.orgDomain}/hosting/groups`
    }
}

function getQueryInputEl(){
    let blkEl = genBlkEl("col-sm-12");
    let inputEl =  $("<input/>", {type: "text", class: "form-control", placeholder: "Search Groups", onInput:"queryStringHandler()", id:"queryStrInput"})
    return blkEl.html(inputEl);
}

function getTagFilters(){
    let tagsSelectEls = [];
    tagGroups.forEach(function(tagGroup, index){
                            if(tagGroup.tags.length > 0){
                                let defaultOpt = `<option class="text-capitalize" value="" selected>${tagGroup.name}</option>`
                                let optEls = tagGroup.tags.map(function (tag) { return `<option class="text-capitalize" value="${tag.id}" ${filterTagIds.includes(tag.id) ? "selected" : ""}>${tag.name}</option>`; });
                                optEls.unshift(defaultOpt);
                                let selectEl = genSelectEl(optEls, tagGroup.isMultiple_select, tagGroup.name.toLowerCase().replace(" ", "") + index);
                                tagsSelectEls.push(selectEl);
                            }
                        });
    return tagsSelectEls.join("");
}

function genBlkEl(classList, elId = null) {
    return $('<div/>', {class: classList, id: elId});
}

function genSelectEl(optEls, multiple, id){
    return `<select name="tagIdsList" id="${id}" ${(multiple == 1)? 'multiple="multiple"' : ''}>${optEls}</select>`
}

function addEventTriggers(){
    $(".groupTypeBlkEl").hover(function(){
        $(this).css("cursor", 'pointer');
    });

    $(".groupTypeBlkEl").click(function(){
        let gTypeName = $(this).attr("data-name");
        location = `${siteUrl}/${org.orgDomain}/hosting/groups/${gTypeName}`;
    });
    $(".footer").addClass("fixed-bottom");
}

function queryStringHandler(){
    queryStr = $("#queryStrInput").val();
    console.log(queryStr);
}