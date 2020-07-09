$(function () {
    $(".container-fluid").addClass("m-0 p-0");
    $(".container-fluid").css({ width: "100vw" });
    $(".wrapper").css("padding-top", "118px");
    $("#navigation .navigation-menu").addClass("pl-3");
    $(".groupSortable").sortable({
        handle: ".handle",
        cursor: "move",
        connectWith: '.groupSortable',
        stop: function (ev, ui) {
            updateTagGroupOrders(this);
        }
    });
    $(".groupSortable").disableSelection();
    fetchTagGroupsWithTags();
});
let tagGroups = [];

function fetchTagGroupsWithTags() {
    let apiPath = siteUrl + '/api/groups/tagsListWithGroups';
    let queryData = {};
    let apiProps = { url: apiPath, method: 'get', queryData };
    fetchDataApi(apiProps, function (data) {
        tagGroups = data
        updateTabs();
    });
}

function updateTabs() {
    tagGroups.sort(function (a, b) {
        return a.order - b.order;
    });
    tagGroups = tagGroups.map(function (item) {
        item.tags.sort(function (a, b) {
            return a.order - b.order
        });
        return item;
    })

    let tagGroupEls = tagGroups.map(function (gItem, index) {
        let randNum = generateRandNum();
        let tagEls = gItem.tags.map(function (item, index) {
            return generateChildNode(randNum, item);
        });
        if (tagEls.length <= 0) {
            tagEls.push(`<h6 class="text-center text-danger">No Tags Present</h6>`);
        }
        return generateParentNode(randNum, gItem, tagEls);
    });

    let newTagGroupEl = generatenNewTagGroup();
    tagGroupEls.push(newTagGroupEl);
    $(".groupSortable").html(tagGroupEls);
    $(".itemsSortable").sortable({
        handle: ".child_handle",
        cursor: "move",
        stop: function (ev, ui) {
            updateTagOrders(this);
        }
    });
    $(".tag_list_items").disableSelection();
    $(".edit_child_node").hide();
    $(".edit_group_node").hide();
}

function generateChildNode(randNum, item) {
    return `<div class="row tag_items child_node" data-randNum="${randNum}" data-id="${item.id}", data-name="${item.name}"><div class="col-sm-12 sort_child_node pb-1 pt-1"><i class="fa fa-bars child_handle"></i><span class="capitalized child_value">${item.name}</span><i class="fa fa-edit btn btn-sm pull-right child_edit_btn"></i></div><div class="col-sm-12 edit_child_node"><div class="input-group input-group-sm mb-2"><input class="child_node_input form-control" value="${item.name}"><div class="input-group-append"><i class="btn btn-danger fa fa-times child_node_delete"></i><button class="btn btn-sm btn-success pull-right child_node_update"><i class="fa fa-check"></i></button></div></div></div></div>`
}

function generateParentNode(randNum, gItem, tabEls) {
    let wrapper = generateGroupWrapper(randNum, gItem.name, gItem.isPublic, gItem.isMultiple_select)
    let sortEl = generateGroupNode(randNum, gItem, tabEls);
    return `<div class="col-sm-12 col-md-3 mb-3 parent_node group_${randNum}" data-groupId="${gItem.id}" data-name="${gItem.name}" data-isPublic="${gItem.isPublic}" data-randNum="${randNum}" data-isMultiple_select="${gItem.isMultiple_select}">${sortEl}${wrapper}</div>`
}
function generateGroupNode(randNum, gItem, tabEls) {
    return `<div class="row m-2 sort_group_node"><div class="col-sm-12 card p-0"><div class="card-title pl-2 pr-2 text-white bg-secondary"><h6 class="capitalized"><i class="fa fa-bars handle"></i>  ${gItem.name}<i class="fa fa-edit btn btn-sm pull-right edit_group_btn"></i></h6></div><div class="card-body ml-4 mr-4 mt-0 mb-0 pt-1 pb-0 child_nodes_group itemsSortable">${tabEls.join("")}<small class="error_msg_${randNum} text-danger"></small></div><div class="card-body m-0 pb-2"><div class="input-group"><input type="text" class="form-control new_tag_${randNum}" placeholder="add tag " data-randNum="${randNum}"><div class="input-group-append"><span class="input-group-text bg-success text-white" onClick="addNewTag(${randNum})" style="cursor:pointer">+</span></div></div></div></div></div>`
}
function generateGroupWrapper(randNum, name = null, isPublic = true, isMultiple_select = true) {
    return `<div class="row m-2 edit_group_node card"><div class="col-sm-12 card p-0"><div class="card-body"><div class="form-group"><label>Name</label><input type="text" class="form-control group-name" value="${name ? name : ''}" placeholder="Example: Stage of Life"><small class="error_msg_${randNum} text-danger"></small></div><div class="form-group"><div class="form-check"><input type="checkbox" ${isPublic ? 'checked' : ''}  class="form-control-chk form-check-input form_input_req group-isPublic"><label class="form-check-label"> Display tag publicly</label></div></div><div class="form-group"><div class="form-check"><input type="checkbox" ${isMultiple_select ? 'checked' : ''}  class="form-control-chk form-check-input form_input_req group-isMultiple_select"><label class="form-check-label"> Can one group belong to many Neighborhoods?</label></div></div></div><div class="card-body" style="bottom:0;"><h6 >${name ? '<button class="btn btn-danger btn-sm delete_group_btn">Delete</button>' : ''}<button class="btn btn-success btn-sm pull-right ml-3 save_group_btn">Save</button><button class="btn btn-light btn-sm pull-right cancel_group_btn">Cancel</button></h6></div></div></div>`
}

function generatenNewTagGroup() {
    let randNum = generateRandNum();
    let wrapper = generateGroupWrapper(randNum);
    return `<div class="col-sm-12 col-md-3 mb-3 parent_node group_${randNum}" data-groupId="create_new_node_id" data-randnum="${randNum}"><div class="card p-2 m-2 add_group_btn_blk"><div class="card-body text-center blk_center"><i class="btn btn-success fa fa-plus add_group_btn"></i><h5>Add Tag Group</h5></div></div>${wrapper}</div>`;
}

function generateRandNum() {
    return Math.floor(Math.random() * (100000 - 1 + 1) + 57);
}

function showTagErr(randomNum, msg) {
    $(".error_msg_" + randomNum).text(msg);
    setTimeout(function () {
        $(".error_msg_" + randomNum).text(null);
    }, 3500);
}

$(document).on('click', '.child_edit_btn', function () {
    $(this).parent().siblings(".edit_child_node").show(500);
    $(this).closest(".sort_child_node").hide();
})

$(document).on('click', ".edit_group_btn", function () {
    $(this).closest(".sort_group_node").siblings(".edit_group_node").show(500);
    $(this).closest(".sort_group_node").hide();
})

$(document).on('click', '.add_group_btn', function () {
    $(this).closest(".add_group_btn_blk").siblings(".edit_group_node").show(500);
    $(this).closest(".add_group_btn_blk").hide();
})

$(document).on('click', ".child_node_delete", function () {
    let tagDetails = {};
    let childNode = $(this).closest(".child_node");
    tagDetails.name = childNode.attr('data-name');
    tagDetails.id = childNode.attr("data-id");
    let local = this;
    getConfirmation(`Delete Confirmation tag <strong>${tagDetails.name}</strong>`, `This is a permanent action and the tag will be removed from all groups.`, function (status) {
        if (status) {
            $(local).closest('.child_node').remove();
            let apiPath = siteUrl + '/api/groups/tags/deleteTag/' + tagDetails.id;
            let queryData = {};
            let apiProps = { url: apiPath, method: 'get', queryData };
            fetchDataApi(apiProps, function (data) { });
        }
    });
})
$(document).on("click", ".child_node_update", function () {
    let tagDetails = {};
    let childNode = $(this).closest(".child_node");
    tagDetails.name = $(this).parent().siblings(".child_node_input").val();
    tagDetails.id = childNode.attr("data-id");
    childNode.find(".sort_child_node .child_value").html(tagDetails.name);
    childNode.find(".edit_child_node").hide();
    childNode.find(".sort_child_node").show(500);
    let apiPath = siteUrl + "/api/groups/tags/createOrUpdateTag";
    let queryData = { id: tagDetails.id, name: tagDetails.name };
    let apiProps = { url: apiPath, method: 'post', queryData };
    fetchDataApi(apiProps, function (data) { });
})
$(document).on("click", ".delete_group_btn", function () {
    let group_node = $(this).closest(".parent_node");
    let groupDetails = {};
    groupDetails.name = group_node.attr("data-name");
    groupDetails.id = group_node.attr("data-groupId");
    getConfirmation(`Delete Confirmation tag group <strong>${groupDetails.name}</strong>`, `This is a permanent action and the tag will be removed from all groups.`, function (status) {
        if (status) {
            group_node.remove();
            let apiPath = siteUrl + '/api/groups/tags/deleteGroup/' + groupDetails.id;
            let queryData = {};
            let apiProps = { url: apiPath, method: 'get', queryData };
            fetchDataApi(apiProps, function (data) { });
        }
    });
});
$(document).on("click", ".cancel_group_btn", function () {
    let group_node = $(this).closest(".parent_node");
    let groupId = group_node.attr("data-groupId");
    let randNum = group_node.attr("data-randNum");
    if (groupId == "create_new_node_id") {
        $(this).closest(".edit_group_node").hide();
        $(this).closest(".edit_group_node").siblings(".add_group_btn_blk").show(500);
    } else {
        let tagGroup = tagGroups.find(function (item) { return item.id == groupId });
        regenerateGroupNode(randNum, group_node, tagGroup);
    }
})
$(document).on("click", ".save_group_btn", function () {
    let group_node = $(this).closest(".parent_node");
    let groupId = group_node.attr("data-groupId");
    let randNum = group_node.attr('data-randnum');
    let name = group_node.find(".group-name").val();
    let isPublic = group_node.find(".group-isPublic").prop('checked');
    let isMultiple_select = group_node.find(".group-isMultiple_select").prop('checked');
    let order = $(".groupSortable").children().length;
    let tagGroup = {};
    if (name) {
        tagGroup.name = name;
        tagGroup.isPublic = isPublic;
        tagGroup.isMultiple_select = isMultiple_select;

        let apiPath = siteUrl + '/api/groups/createOrUpdateTagGroup';
        let queryData = { name, isPublic, isMultiple_select, order, groupId };
        let apiProps = { url: apiPath, method: 'post', queryData };
        fetchDataApi(apiProps, function (data) {
            if (groupId == "create_new_node_id") {
                tagGroup.order = order;
                tagGroup.tags = [];
                tagGroup.id = data.id;
                tagGroups.push(tagGroup);
            } else {
                let groupIndex = tagGroups.findIndex(function (item) { return item.id == groupId });
                tagGroup.tags = tagGroups[groupIndex].tags;
                tagGroups.splice(groupIndex, 1, tagGroup);
            }
            $(this).attr("disabled", false);
            regenerateGroupNode(randNum, group_node, tagGroup);
            if (groupId == "create_new_node_id") {
                let newGroupBlk = generatenNewTagGroup();
                $(".groupSortable").append(newGroupBlk);
                $(".edit_group_node").hide();
            }
        });

    } else {
        $(this).removeAttr("disabled");
        showTagErr(randNum, "Enter valid Group Tag name")
    }
})

function regenerateGroupNode(randNum, group_node, gItem) {
    let tagEls = gItem.tags.map(function (item, index) {
        return generateChildNode(randNum, item);
    });
    if (tagEls.length <= 0) {
        tagEls.push(`<h6 class="text-center text-danger">No Tags Present</h6>`);
    }
    let wrapper = generateGroupWrapper(randNum, gItem.name, gItem.isPublic, gItem.isMultiple_select)
    let sortEl = generateGroupNode(randNum, gItem, tagEls);
    group_node.attr("data-groupId", gItem.id);
    group_node.attr("data-name", gItem.name);
    group_node.attr("data-isPublic", gItem.isPublic);
    group_node.attr("data-isMultiple_select", gItem.isMultiple_select);
    group_node.empty();
    group_node.append(sortEl);
    group_node.append(wrapper);
    group_node.find(".edit_child_node").hide();
    group_node.find(".sort_group_node").show(500);
    group_node.find(".edit_group_node").hide();
}

function addNewTag(randomNum) {
    let newTag = $(".new_tag_" + randomNum).val();
    if (newTag) {
        let groupBlk = $(".group_" + randomNum)
        let groupId = groupBlk.attr('data-groupId');
        let tagPresent = {};
        let sGroup = tagGroups.find(function (item) { return item.id == groupId; });
        if (sGroup) {
            tagPresent = sGroup.tags.find(function (item) {
                return item.name.toLowerCase() == newTag.toLowerCase();
            });
            if (tagPresent) {
                showTagErr(randomNum, "Tag Already Present")
            } else {
                $(".error_msg_" + randomNum).remove();
                let apiPath = siteUrl + '/api/groups/tags/createOrUpdateTag';
                let newTagObj = { id: "newTag", tagGroup_id: groupBlk.attr("data-groupId"), name: newTag, order: sGroup.tags.length };
                let apiProps = { url: apiPath, method: 'post', queryData: newTagObj };
                fetchDataApi(apiProps, function (data) {
                    newTagObj.id = data.id;
                    delete newTagObj.tagGroup_id;
                    let newTagEl = generateChildNode(randomNum, newTagObj);
                    if (sGroup.tags.length <= 0) {
                        groupBlk.find(".child_nodes_group").empty();
                    }
                    sGroup.tags.push(newTagObj);
                    groupBlk.find(".child_nodes_group").append(newTagEl);
                    groupBlk.find(".child_nodes_group").append(`<small class="error_msg_${randomNum} text-danger"></small>`);
                    $(".edit_child_node").hide();
                    $(".new_tag_" + randomNum).val("");
                });
            }
        }
    } else {
        showTagErr(randomNum, "Enter tag Name");
    }
    $(".itemsSortable").sortable({
        handle: ".child_handle",
        cursor: "move",
        stop: function (ev, ui) {
            updateTagOrders(this);
        }
    });
}

function updateTagOrders(elBlk) {
    let tagsList = [];
    $(elBlk).children(".child_node").each(function () {
        tagsList.push($(this).attr("data-id"));
    });
    let apiPath = siteUrl + '/api/groups/tags/updateTagsOrder';
    let apiProps = { url: apiPath, method: 'post', queryData: tagsList };
    fetchDataApi(apiProps, function (data) { });
}

function updateTagGroupOrders(elBlk) {
    let tagGrpList = [];
    $(elBlk).children(".parent_node").each(function () {
        tagGrpList.push($(this).attr("data-groupId"));
    });
    tagGrpList.splice(tagGrpList.length - 1, 1)
    let apiPath = siteUrl + '/api/groups/tags/updateTagGroupsOrder';
    let apiProps = { url: apiPath, method: 'post', queryData: tagGrpList };
    fetchDataApi(apiProps, function (data) { });
}