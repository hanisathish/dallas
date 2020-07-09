let scheduleId = recievedData = null;
let events = volunteer_types = [];
let sFields = ['title', 'date', 'time', 'event_id', 'location_id', 'building_block', 'type_of_volunteer', 'checker_count', 'is_manual_schedule', 'notification_flag'];
let buildBlks = [{ id: 1, name: "daily" }, { id: 2, name: "weekly" }, { id: 999, name: "none" }];
let locations = [{ id: 1, name: "location1" }, { id: 2, name: "location2" }, { id: 3, name: "location3" }];
let schedule = {};
let membersList = [];
let searchMemberList = [];
let checker_count = 1;

$(document).ready(function () {
    $(".container-fluid").addClass("m-0 p-0").css({ width: "100vw" });
    $(".wrapper").css("padding-top", "118px");
    scheduleId = $("#scheduleId").val();
    appendModalToBody("assignMemberModal");
    fetchFormSupportedData();
});

function fetchFormSupportedData() {
    let apiPath = siteUrl + '/api/settings/schedule/createRelatedData';
    let apiProps = { url: apiPath, method: 'post', queryData: { scheduleId } };
    fetchDataApi(apiProps, function (data) {
        recievedData = data;
        extractData();
    });
}

function extractData() {
    if (!recievedData.schedule) {
        sFields.forEach(function (key) { schedule[key] = null; });
        schedule.id = null;
        schedule.assign_ids = [];
        schedule.notification_flag = 1;
        schedule.is_manual_schedule = 1;
    } else {
        schedule = recievedData.schedule;
    }
    // schedule = {"title":"Testing Schedule","date":"2019-09-27","time":"01:00","event_id":"3","location_id":"2","building_block":"","type_of_volunteer":"128","checker_count":"5","is_auto_schedule":false,"is_manual_schedule":false,"notification_flag":null,"id":null,"assign_ids":[1,2,3,4],"notify_type":"4"};
    events = recievedData.events;
    volunteer_types = recievedData.volunteer_types;
    if (schedule.assign_ids.length > 0) fetchAssignedList();
    generateForm();
}

function fetchAssignedList() {
    let apiPath = siteUrl + '/api/settings/schedule/getAssignedMembersList';
    let apiProps = { url: apiPath, method: 'post', queryData: { assign_ids: schedule.assign_ids } };
    fetchDataApi(apiProps, function (data) {
        membersList = data;
        updateMemberList();
    });
}

function generateForm() {
    let valunteerBlk = getSelectBlk("type_of_volunteer_select", "Type Of Volunteer", generateOpts('id', volunteer_types, "mldId", "mldValue"));
    let buildingBlk = getSelectBlk("building_block_select", "Building Block", generateOpts("id", buildBlks, 'id', "name", true));
    let locationBlk = getSelectBlk("location_id_select", "Location", generateOpts("id", locations, 'id', "name"));
    let eventBlk = getSelectBlk("event_id_select", "Event", generateOpts("id", events, "eventId", "eventName"));
    let checkerCountBlk = getCheckerBlk();
    $("#scheduleForm").html([generateTitleBlk(), getDateTimeBlk(generateOpts("time")), eventBlk, locationBlk, buildingBlk, valunteerBlk, checkerCountBlk, generateBlk("row card pane p-2", "members_list"), getNotificationBlk(), getActionBlk()]);
    $("#checker_count_select").parent(".row").removeClass("card-body");
    updateFormData();
}

function generateOpts(valType, arr = [], valName = null, propName = null, isSetDefault = false) {
    let opts = (isSetDefault) ? [`<option class="text-secondary" value="">-- Select --</option>`] : [];
    if (valType == "id") {
        arr.forEach(function (item) { opts.push(genOpt(item[valName], item[propName])); })
    } else if (valType == "time") {
        let timeValues = getTimeValues();
        timeValues.forEach(function (item) {
            opts.push(genOpt(item.value, item.label))
        })
    } else {
        for (let i = 1; i < 10; i++) opts.push(genOpt(i, i));
    }
    return opts;
}

function getDateTimeBlk(timeOpts) {
    let rowBlk = generateBlk("row card-body pb-0");
    let dateBlk = generateBlk("col-sm-6 card-body");
    let timeBlk = generateBlk("col-sm-6 ");
    let dateRowBlk = generateBlk("row");
    let dateLabelBlk = genLableBlk('col-sm-3 col-form-label', "Date");
    let dateInputBlk = genInputBlk('col-sm-9', "date_input", "Scheduling Date", "date");
    dateRowBlk.html([dateLabelBlk, dateInputBlk]);
    let timeRowBlk = getSelectBlk("time_select", "Time", timeOpts)
    dateBlk.html(dateRowBlk);
    timeBlk.html(timeRowBlk);
    return rowBlk.html([dateBlk, timeBlk]);
}
function genOpt(val, label) {
    return `<option class="capitalized" value="${val}">${label}</option>`
}
function generateBlk(classList, elId = null) {
    return $('<div/>', { class: classList, id: elId });
}
function genLableBlk(classList, label) {
    return `<label class="${classList}">${label}</label>`
}
function genInputBlk(classList, elId, placeholder, type) {
    return `<div class="${classList}"><input class="form-control" id="${elId}" placeholder="${placeholder}" type="${type}"></div>`
}
function genCheckboxInput(elId) {
    return `<input type="checkbox" class="form-control-chk form-check-input form_input_req" id=${elId}>`
}
function genRadioInput(name, value) {
    return `<input type="radio" name="${name}" value="${value}" class="form-control-chk form-check-input form_input_req">`
}
function genSelectInput(classList, elId, options) {
    return `<select class="form-control ${classList}" id="${elId}">${options.join("")}</select>`
}
function generateTitleBlk() {
    return generateBlk("row card-body pb-0").html([genLableBlk("col-sm-3", "Schedule Title"), genInputBlk("col-sm-9", "title_input", "Schdule Name", "text")])
}
function getSelectBlk(elId, elLabel, options) {
    return generateBlk("row card-body").html([genLableBlk("col-sm-3 pt-2", elLabel), genSelectInput("col-sm-9", elId, options)]);
}
function genBtn(elClass, elLabel, elId = null) {
    return `<button class="${elClass}" id="${elId}">${elLabel}</button>`;
}

function getCheckerBlk() {
    let checkerSelect = generateBlk("col-sm-5").html(getSelectBlk("checker_count_select", "Checker", generateOpts("numbers")));
    // let asBlkEls = generateBlk("form-check auto_assign").html([genCheckboxInput("is_auto_schedule"), genLableBlk("form-check-label", "Auto Scheduling")]);
    // let msBlkEls = generateBlk("form-check manual_assign").html([genCheckboxInput("is_manual_schedule"), genLableBlk("form-check-label", "Manual Scheduling")]);
    // let asBlk = generateBlk("col-sm-3 pt-2").html(asBlkEls);
    // let msBlk = generateBlk("col-sm-3 pt-2").html(msBlkEls);

    let checkerVals = [{ value: 1, label: "Auto Scheduling" }, { value: 2, label: "Manual Scheduling" }];

    let checkerRadioEls = checkerVals.map(function (item) {
        return `<div class="col-sm-3 ml-4 pt-1">${genRadioInput("checker_flag", item.value)} ${genLableBlk("form-check-label", item.label)}</div>`;
    });

    return generateBlk("row card-body").html([checkerSelect, checkerRadioEls.join("")]);
}
function getNotificationBlk() {
    let notifyVals = [{ value: 1, label: "None" }, { value: 2, label: "SMS" }, { value: 3, label: "Mail" }, { value: 4, label: "Both" }];
    let notifyRadioEls = notifyVals.map(function (item) {
        return `<div class="col-sm-2">${genRadioInput("notification_flag", item.value)} ${genLableBlk("form-check-label", item.label)}</div>`;
    });
    let notifyBlkLabel = genLableBlk("col-sm-3", "Notification");
    // $("input:radio[name=notification_flag][value='" + schedule.notification_flag + "']").attr('checked', true);
    // $("form input:radio[name='notification_flag']").filter(`[value="${schedule.notification_flag}"]`).attr('checked', true);
    return generateBlk("row p-4").html([notifyBlkLabel, notifyRadioEls.join("")]);
}

function getActionBlk() {
    let saveBtn = genBtn("btn btn-outline-success btn-sm pull-right ml-3", "Save", "save_schedule");
    let resetBtn = genBtn("btn btn-outline-danger btn-sm pull-right", "Reset", "save_schedule");
    return generateBlk("row mb-3").html(generateBlk("col-sm-12").html([saveBtn, resetBtn]));
}

function updateFormData() {
    sFields = ['title', 'date'];
    let inputEls = ['title', 'date'];
    let selectEls = ['time', 'event_id', 'location_id', 'building_block', 'type_of_volunteer', 'checker_count'];
    // $("form input:radio[name='notification_flag']").filter(`[value="${schedule.notification_flag}"]`).attr('checked', true);
    inputEls.forEach(function (item) { $(`#${item}_input`).val(schedule[item]); });
    // selectEls.forEach(function(item){ $(`#${item}_select option[value=${(schedule[item])? schedule[item]: "" }]`).prop("selected", true); });
    selectEls.forEach(function (item) { if (schedule[item]) $(`#${item}_select`).val(schedule[item]); });
    // checkboxEls.forEach(function (item) { $(`#${item}`).attr("checked", schedule[item]) });
    $("input[type=radio][name=notification_flag]").val([schedule.notification_flag]);
    $("input[type=radio][name=checker_flag]").val([schedule.is_manual_schedule]);
    checker_count = schedule.checker_count;
    if (schedule.is_manual_schedule == 2) {
        $("#members_list").show();
        updateMemberList();
    } else {
        $("#members_list").hide();
    }
}

function validateForm() {
    let errorCount = 0;
    let inputEls = ['title', 'date'];
    let selectEls = ['time', 'event_id', 'location_id', 'building_block', 'type_of_volunteer', 'checker_count'];
    // let checkboxEls = ['is_manual_schedule'];
    inputEls.forEach(function (item) { schedule[item] = $(`#${item}_input`).val(); });
    selectEls.forEach(function (item) { schedule[item] = $(`#${item}_select`).val(); });
    // checkboxEls.forEach(function (item) { schedule[item] = $(`#${item}`).is(':checked'); });
    schedule.notification_flag = $("input[name='notification_flag']:checked").val();
    schedule.is_manual_schedule = $("input[name='checker_flag']:checked").val();
    schedule.assign_ids = membersList.map(function (item) { return item.id });
    let apiPath = siteUrl + '/api/settings/schedule/storeOrUpdateSchedule';
    let apiProps = { url: apiPath, method: 'post', queryData: schedule };
    fetchDataApi(apiProps, function (data) {
        location = siteUrl + "/settings/schedulling";
    });
}

function updateMemberList() {
    let subBlk = generateBlk("card-body pt-0");
    let tableBlk = $("<table/>", { class: "table table-sm", id: "member_list_table" });
    let headerRowEl = getTableHeaders();
    let dataRowEls = null;
    if (membersList.length > 0) {
        dataRowEls = membersList.map(function (item, index) { return genTableRow(index, item) });
    } else {
        dataRowEls = ['<tr><td colspan="5" class="text-center"><small>No records Found.</small></td></tr>'];
    }
    tableBlk.html([headerRowEl, dataRowEls.join("")]);
    let modalBtn = genBtn("btn btn-sm btn-primary pull-right border border-right-3", "Assign <i class='fa fa-plus'></i>", "member_assign_btn");
    $("#members_list").html(subBlk.html([tableBlk, modalBtn]));
    $("#members_list").show(500);
}
function getTableHeaders() {
    let headers = ["Sl.no", "Name", "Image", "Email", ""];
    let thEls = headers.map(function (item) { return `<th>${item}</th>` });
    return $("<tr/>", { class: "member_row" }).html([thEls.join("")]);
}
function genTableRow(index, item) {
    let profile_img = null;
    try {
        profile_img = (item.profile_pic) ? `<img src="${item.profile_pic}" alt="Profile Pic" width="75" height="75">` : `<i class="fa fa-user" aria-hidden="true"></i>`;
    } catch (e) {
        profile_img = `<i class="fa fa-user" aria-hidden="true"></i>`;
    } finally {
        return `<tr><td>${index + 1}</td><td>${item.full_name}</td><td>${profile_img}</td><td>${item.email}</td><td><i class="fa fa-close btn btn-sm text-danger remove_member" data-memberId="${item.id}" data-index="${index}"></i></td></tr>`
    }
    // let profile_img = (item.profile_pic) ? `<img src="${item.profile_pic}" alt="Profile Pic" width="75" height="75">` : `<i class="fa fa-user" aria-hidden="true"></i>`;

}

function updateModalContent() {
    let modalCloseBtn = genBtn("btn btn-sm btn-primary pull-right border border-right-3 modal_close", "Close");
    $("#assignMemberModal .modalTitle").html("<h5>Search Members from Database</h5>");
    updateModalBodyContent();
    $("#assignMemberModal .modalFooter").html(modalCloseBtn);
}

function updateModalBodyContent() {
    if (membersList.length < checker_count) {
        $("#assignMemberModal .modalBody").html(getSearchBlock());
    } else {
        $("#assignMemberModal .modalBody").html('<div class="text-danger"> Assigned Members count has been reached Checkers count</div>');
    }
}
function getSearchBlock() {
    return `<input type="text" class="input-lg" style="width:100%; padding:5px" id="searchStr" value="" onInput="getSearchResults()" placeholder="Search for someone...">
            <div id="search_users_list" class="list-group vh-overflow-40 " style="width:100%"></div>`;
}

// Get Search Users list for search query from API
function getSearchResults() {
    let searchStr = $("#searchStr").val();
    let exceptIds = membersList.map(function (item) { return item.id });
    searchMemberList = [];
    if (searchStr.length > 1) {
        let apiPath = siteUrl + '/api/settings/schedule/getMemberSearchList';
        let apiProps = { url: apiPath, method: 'post', queryData: { searchStr, exceptIds } }
        fetchDataApi(apiProps, function (data) {
            searchMemberList = data.filter(function (item) {
                return !exceptIds.includes(item.id);
            });
            updateSearchUsrList();
        })
    } else {
        $("#search_users_list").html("<div></div>");
    }
}

function updateSearchUsrList() {
    $(".modalBody").removeClass("text-center");
    let records = [];
    if (searchMemberList.length > 0) {
        searchMemberList.forEach(function (item, index) {
            let block = `<div class="list-group-item list-group-item-action hover-focus" data-searchMemIndex="${index}">
                            <h6 class="no-margin">${item.full_name}</h6>
                            <p class="text-muted no-padding no-margin">${item.email}</p>
                        </div>`;
            records.push(block);
        })
    } else {
        let noRecord = `<small class="text-danger">No records found</small>`;
        records.push(noRecord);
    }
    $("#search_users_list").html(records);
}



$(document).on("change", "input[type=radio][name=checker_flag]", function () {
    if ($(this).val() == 2) {
        updateMemberList();
    } else {
        $("#members_list").hide(500);
    };
})

$(document).on("click", ".remove_member", function () {
    let memberId = $(this).attr("data-memberid");
    let memberIndex = $(this).attr("data-index");
    membersList.splice(memberIndex, 1);
    updateMemberList();
})

$(document).on('change', "#checker_count_select", function () {
    let count = $(this).val();
    if (count > membersList.length) {
        $("#member_assign_btn").show(500);
        checker_count = count;
    } else if (count == membersList.length) {
        $("#member_assign_btn").hide(500);
        checker_count = count
    } else {
        let cnfBody = "<small class='text-danger'>Checkers value greater than to assigned members count.</small> <br/><small> <b>Are you sure to remove some assigned members from assigned List</b></small>";
        getConfirmation("Something went wrong", cnfBody, function (isAccepted) {
            if (isAccepted) {
                membersList.splice(count - 1, membersList.length);
                checker_count = count;
                $("#member_assign_btn").hide(500);
            } else {
                $(this).val(checker_count);
            }
        })
    }
});

$(document).on("click", "#member_assign_btn", function (e) {
    e.preventDefault();
    updateModalContent();
    $("#assignMemberModal").modal("show");
});
$(document).on("click", ".modal_close", function (e) {
    e.preventDefault();
    $("#assignMemberModal").modal("hide");
    if (checker_count > membersList.length) {
        $("#member_assign_btn").show();
    }
})
$(document).on("click", "#save_schedule", function (e) {
    e.preventDefault();
    validateForm();
});
$(document).on("click", ".list-group-item", function () {
    let indexVal = $(this).attr("data-searchMemIndex");
    membersList.push(searchMemberList[indexVal]);
    searchMemberList.splice(indexVal, 1);
    updateMemberList();
    if (membersList.length >= checker_count) {
        $("#assignMemberModal .modalBody").hide();
        $("#assignMemberModal .modalBody").html('<div class="text-danger"> Assigned Members count has been reached Checkers count</div>');
        $("#assignMemberModal .modalBody").show(500);
        $("#member_assign_btn").hide();
    } else {
        $(this).html("<small class='text-success'>Added in Assignment List</small>");
        let self = this;
        setTimeout(function () {
            $(self).remove();
            updateSearchUsrList();
        }, 1500);
        updateSearchUsrList();
        $("#member_assign_btn").hide();
    }
})

