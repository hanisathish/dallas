let personalFieldsList = [{ title: "Phone", type: 1, tag: "mobile_no", icon: "fa fa-phone", required: false }, { title: "Address", type: 1, tag: "address", icon: "fa fa-address-card", required: false }, { title: "Birthday", type: 1, tag: "dob", icon: "fa fa-birthday-cake", required: false }, { title: "Medical Note", type: 1, tag: "medical_note", icon: "fa fa-heartbeat", required: false }, { title: "Marital Status", type: 1, tag: "marital_status", icon: "fa fa-users", required: false }, { title: "Social Profile", type: 1, tag: "life_stage", icon: "fa fa-user", required: false }, { title: "Gender", tag: "gender_id", type: 1, icon: "fa fa-mars-double", required: false }];
let basicFieldsList = [{ fieldTitle: "Text", inputType: "text", type: 2, label: "", placeholder: "", required: false }, { fieldTitle: "Paragraph", inputType: "textarea", type: 2, label: "", placeholder: "", name: '', required: false }, { fieldTitle: "Select", inputType: "select", type: 2, label: "", name: "", options: [{ option: '', value: '' }], required: false }, { fieldTitle: "Date", inputType: "date", type: 2, label: "", name: "", options: [{ option: '', value: '' }], required: false }, { fieldTitle: "Checkbox", inputType: "checkbox", type: 2, label: "", name: "", options: [{ option: '', value: '' }], required: false }, { fieldTitle: "Radio Button", inputType: "radioBtn", type: 2, label: "", name: "", options: [{ option: '', value: '' }], required: false }, { fieldTitle: "Number", inputType: "number", type: 2, label: "", placeholder: "", name: '', required: false }];
let preDefinedData = { formTitle: '', formDes: "", elObject: [] };
let outputData = {};
let formTitle = "";
let formDes = "";
let formId = null;
let urlPath = location.pathname.split('/');
let form_id_hidden = $("#form_id_hidden").val();
//if (urlPath.length === 5) {
if (form_id_hidden != "") {
    //formId = urlPath[urlPath.length - 1];
    formId = form_id_hidden;
    let apiPath = siteUrl + '/api/settings/forms/content/' + formId;
    let queryData = {};
    let apiProps = { url: apiPath, method: 'get', queryData };
    fetchDataApi(apiProps, function (data) {
        preDefinedData = data;
        resetForm();
    });
}
$(document).ready(function () {
    $(".footer").css("display", "none");
    $("#formTitle").val(formTitle);
    $('#formDes').val(formDes);
    updateProfileFields();
    updateBasicFields();
    basicFieldsList.forEach(function (item) {
        $(".form_bal_" + item.inputType).draggable({
            helper: function () { return getGeneralHTMLfields(item); },
            connectToSortable: ".form_builder_area"
        });
    });
    personalFieldsList.forEach(function (item) {
        $(".form_bal_" + item.tag).draggable({
            helper: function () { return getProfileHTMLFields(item); },
            connectToSortable: ".form_builder_area"
        });
    });
    $(".form_builder_area").sortable({
        cursor: 'move',
        placeholder: 'placeholder',
        start: function (e, ui) {
            ui.placeholder.height(ui.helper.outerHeight());
            removeEmptyBlk();
        },
        stop: function (ev, ui) {
            enableOrDisableProfileFields();
            generateFormPreview();
            getEmptyBlk();
        }
    });
    resetForm();
    updateReviewBlock();
    generateFormPreview();
    getEmptyBlk();
    $(".form_builder_area").disableSelection();
});

$(document).on('click', '.remove_more_options', function () {
    var randNum = $(this).attr('data-randNum');
    $(this).closest('.options_row_' + randNum).hide('400', function () {
        $(this).remove();
        generateFormPreview();
    });
});

$(document).on('click', '.remove_bal_field', function () {
    var randNum = $(this).attr('data-randNum');
    $(this).closest('.li_' + randNum).hide("400", function () {
        let dataType = $('.form_output_block_' + randNum).attr('data-type');
        if (dataType == 1) {
            let dataTag = $('.form_output_block_' + randNum).attr('data-tag');
            $(".form_bal_" + dataTag).draggable('enable').removeClass("bg-secondary text-white");
        }
        $(this).remove();
        generateFormPreview();
        getEmptyBlk();
    })
});
$(document).on('click', '.add_more_options', function () {
    $(this).closest('.form_builder_field').css('height', 'auto');
    var randNum = $(this).attr('data-randNum');
    var optNum = generateRandNum();
    let optionEl = `<div data-randNum="${randNum}" class="row options_row_${randNum} pad-b-5" data-opt="${optNum}"><div class="col-md-4"><div class="form-group"><input type="text" value="" placeholder="Option" class="c_opt form-control"/></div></div><div class="col-md-4"><div class="form-group"><input type="text" value="" placeholder="Value" class="c_val form-control"/></div></div><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_options" data-randNum="${randNum}"></i><i class="margin-top-5 margin-left-5 fa fa-times-circle default_red fa-2x remove_more_options" data-randNum="${randNum}"></i></div></div>`;
    generateFormPreview();
    $('.field_extra_info_' + randNum).append(optionEl);
});
function updateProfileFields() {
    let profileEls = personalFieldsList.map(function (item) {
        return `<li class="form_bal_${item.tag}"><a href="javascript:;"><small><i class="${item.icon}"></i></small> ${item.title}</a></li>`;
    });
    $(".profile_fields").html(profileEls);
}
function updateBasicFields() {
    let generalEls = basicFieldsList.map(function (item) {
        return `<li class="form_bal_${item.inputType}"><a href="javascript:;"><small><i class="fa fa-plus-circle pull-left"></i></small> ${item.fieldTitle}</a></li>`;
    });
    $(".basic_fields").html(generalEls);
}
function enableOrDisableProfileFields() {
    personalFieldsList.forEach(function (item, index) {
        $(".form_bal_" + item.tag).draggable('enable').removeClass("bg-secondary text-white");
    });
    var formOutputEls = $('.form_builder_area .form_output');
    formOutputEls.each(function () {
        var tag = $(this).attr('data-tag');
        $(".form_bal_" + tag).draggable('disable').addClass("bg-secondary text-white");
    })
}
function getGeneralHTMLfields(item) {
    var randNum = generateRandNum();
    let blockCloseBtn = generateBlockCloseBtn(randNum, item.fieldTitle + " Element");
    let requiredElBlock = generateRequiredElBlock(randNum, item);
    let inputBlocks = generateContentBlkForGeneral(randNum, item);
    var blockEl = `${blockCloseBtn}<hr/><div class="row form_output form-font-13 form_output_block_${randNum}" data-type="${item.type}" data-fieldTitle="${item.fieldTitle}" data-inputType="${item.inputType}" data-randNum="${randNum}">${inputBlocks}${requiredElBlock}</div>`;
    return $('<div>').addClass('li_' + randNum + ' form_builder_field').html(blockEl);
}

function getProfileHTMLFields(item) {
    var randNum = generateRandNum();
    var blockCloseBtn = generateBlockCloseBtn(randNum, '');
    var inputBlocks = generateContentBlkForProfile(randNum, item);
    var requiredElBlock = generateRequiredElBlock(randNum, item);
    var html = `${blockCloseBtn}<hr/><div class="row form_output form-font-13 form_output_block_${randNum}" data-type="${item.type}" data-title="${item.title}" data-tag="${item.tag}"data-iconList="${item.icon}" data-randNum="${randNum}">${inputBlocks}${requiredElBlock}</div>`;
    return $('<div>').addClass('li_' + randNum + ' form_builder_field').html(html);
}

function generateBlockCloseBtn(randNum, elTitle) {
    return `<div class="row"><div class="col-sm-12"><strong>${elTitle}<button type="button" class="btn btn-outline-danger btn-sm remove_bal_field pull-right" data-randNum="${randNum}"><i class="fa fa-times"></i></button></strong></div></div>`
}
function generateRequiredElBlock(randNum, item) {
    return `<div class="col-sm-12"><hr/><div class="form-check"><input data-randNum="${randNum}" id="required${randNum}" type="checkbox" value="${item.isRequired ? 'checked' : ''}"  class="form-control-chk form-check-input form_input_req"><label class="form-check-label" for="required${randNum}"> Required</label></div></div>`;
}

function generateContentBlkForProfile(randNum, item, isDisabled = true) {
    switch (item.title) {
        case "Phone":
            return generateInputField({ name: item.tag, value: '', placeholder: item.title, type: "text" }, item.title, isDisabled, "form_input_name", true, []);
            break;
        case "Address":
            let streetAdr = generateInputField({ placeholder: "Street Address", value: '', type: 'text' }, '', isDisabled, "form_input_street", false, []);
            let aptAdr = generateInputField({ placeholder: "Apt/unit/box", value: '', type: 'text' }, '', isDisabled, "form_input_apt", false, []);
            let cityAdr = generateInputField({ placeholder: "City", value: '', type: 'text' }, '', isDisabled, "form_input_city", false, []);
            let stateAdr = generateInputField({ placeholder: "State", value: '', type: 'text' }, '', isDisabled, "form_input_state", false, []);
            let zipAdr = generateInputField({ placeholder: "Zip Number", value: '', type: 'text' }, '', isDisabled, "form_input_zip", false, []);
            return `<div class="col-sm-12"><div class="row" tyle="padding:10px;"><div class="col-sm-6"><label>Street Address</label>${streetAdr}</div><div class="col-sm-5"><label>Apt/unit/box</label>${aptAdr}</div></div><div class="row"><div class="col-sm-4"><label>City</label>${cityAdr}</div><div class="col-sm-4"><label>State</label>${stateAdr}</div><div class="col-sm-3"><label>Zip Code</label>${zipAdr}</div></div></div>`;
            break;
        case "Birthday":
            return generateInputField({ name: item.tag, value: "", placeholder: "dd/mm/yyyy", type: "date" }, item.title, isDisabled, "form_input_date", true, []);
            break;
        case "Medical Note":
            return generateInputField({ name: item.tag, value: '', placeholder: "Medical Note", type: "textarea" }, item.title, isDisabled, "form_input_note", true, []);
            break;
        case "Marital Status":
            return generateInputField({ name: item.tag, value: '', placeholder: "select Marital Status", type: "select" }, item.title, isDisabled, "form_input_name", true, [{ name: "Married", value: "married" }]);
            break;
        case "Gender":
            return generateInputField({ name: item.tag, value: "male", paceholder: 'Select Gender', type: "select" }, item.title, isDisabled, "form_input_name", true, [{ name: "Male", value: "male" }]);
            break;
        case "Social Profile":
            return generateInputField({ name: item.tag, value: '', placeholder: item.title, type: "text" }, item.title, true, "form_input_name", true, []);
            break;
        default:
            return '';
            break;
    }
}
function generateContentBlkForGeneral(randNum, item) {
    switch (item.fieldTitle) {
        case "Text":
        case "Paragraph":
        case "Date":
        case "Number":
            let labelEl = generateInputField({ name: 'label_' + randNum, value: item.label, placeholder: "Label", type: "text" }, '', false, "form_input_label", true, []);
            let plasceholderEl = generateInputField({ name: 'label_' + randNum, value: item.placeholder, placeholder: "Placeholder", type: "text" }, '', false, "form_input_placeholder", true, []);
            // let nameEl = generateInputField({ name: 'label_' + randNum, value: item.name, placeholder: "Element Name", type: "text" }, '', false, "form_input_name", true, []);
            return labelEl + plasceholderEl;
            break;
        case "Select":
        case "Checkbox":
        case "Radio Button":
            let labelEl1 = generateInputField({ name: 'label_' + randNum, value: item.label, placeholder: "Lable", type: "text" }, item.title, false, "form_input_label", true, []);
            // let nameEl1 = generateInputField({ name: 'name_' + randNum, value: item.name, placeholder: "Element Name", type: "text" }, '', false, "form_input_name", true, []);
            let optEl1 = generateOptionValuePairs(randNum, item);
            return `${labelEl1} ${optEl1}`;
            break;
    }
}
function generateOptionValuePairs(randNum, item) {
    let optNum = generateRandNum();
    let optionEls = "";
    item.options.forEach(function (lItem, index) {
        let removeOptEl = index == 0 ? "" : `<i class="margin-top-5 margin-left-5 fa fa-times-circle default_red fa-2x remove_more_options" data-randNum="${randNum}"></i>`;
        optionEls += `<div class="col-md-4"><div class="form-group"><input type="text" value="${lItem.option ? lItem.option : ''}" placeholder="Option" class="c_opt form-control"/></div></div><div class="col-md-4"><div class="form-group"><input type="text" value="${lItem.option ? lItem.option : ''}" placeholder="Value" class="c_val form-control"/></div></div><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_options" data-randNum="${randNum}"></i>${removeOptEl}</div>`
    })
    return `<div class="col-md-12"><div class="field_extra_info_${randNum}"><div data-randNum="${randNum}" class="row options_row_${randNum} pad-b-5" data-opt="${optNum}">${optionEls}</div></div></div>`
}
function generateInputField(attrs = {}, label, isDisabled, addClass = null, withBlock = false, options = []) {
    let currentEl = null;
    let textInputTypes = ["text", "number", "email", "checkbox", "date", "radio", "password"]
    if (textInputTypes.includes(attrs.type)) {
        currentEl = $('<input/>').attr(attrs).prop("disabled", isDisabled).addClass("form-control " + addClass);
    } else if (attrs.type === "textarea") {
        currentEl = $('<textarea/>').attr(attrs).prop("disabled", isDisabled).addClass("form-control form_input_name");
        if (isDisabled) {
            currentEl.addClass("text-secondary");
        }
    } else if (attrs.type === "select") {
        currentEl = $("<select>").addClass("form-control form_input_name form-font-13").prop("disabled", isDisabled);
        options.forEach(function (option) {
            let opt = $('<option/>').attr({ value: option.value }).text(option.name);
            currentEl.append(opt);
        });
    }
    if (withBlock) {
        let labelEl = $("<lable>").text(label);
        let result = $("<div>").addClass('col-sm-12').html([labelEl, currentEl]);
        return result[0].outerHTML;
    } else {
        return currentEl[0].outerHTML;
    }
}
function generateRandNum() {
    return Math.floor(Math.random() * (100000 - 1 + 1) + 57);
}

// Form Review Related Logic
$(document).on('keyup change', '.form-control', function () {
    generateFormPreview();
});
$(document).on("change", ".form-control-chk", function () {
    generateFormPreview();
});

function generateFormPreview() {
    var formOutputArray = [];
    var formOutputEls = $('.form_builder_area .form_output');
    formOutputEls.each(function () {
        var type = $(this).attr('data-type');
        if (type == 1) {
            let pObj = {}
            pObj.title = $(this).attr('data-title');
            pObj.type = type;
            pObj.tag = $(this).attr('data-tag');
            pObj.icon = $(this).attr('data-icon');
            pObj.isRequired = $(this).find(".form-check-input").is(":checked");
            formOutputArray.push(pObj);
        } else {
            // General Elements
            let randomNum = $(this).attr('data-randNum');
            let gObj = {};
            gObj.fieldTitle = $(this).attr('data-fieldTitle');
            gObj.inputType = $(this).attr('data-inputType');
            gObj.type = type;
            gObj.label = $(this).find(".form_input_label").val();
            gObj.label = gObj.label ? gObj.label : "";
            gObj.placeholder = $(this).find(".form_input_placeholder").val();
            // gObj.name = $(this).find(".form_input_name").val();
            gObj.isRequired = $(this).find(".form-check-input").is(":checked");
            gObj.options = [];
            $(".field_extra_info_" + randomNum + " .options_row_" + randomNum).each(function () {
                let opt = {};
                opt.option = $(this).find('.c_opt').val();
                opt.value = $(this).find('.c_val').val();
                gObj.options.push(opt);
            });
            formOutputArray.push(gObj);
        }
    });
    outputData = {};
    outputData.formTitle = $("#formTitle").val();
    outputData.formDes = $('#formDes').val();
    outputData.elObject = formOutputArray;
    updateReviewBlock();
}

function updateReviewBlock() {
    let formHeaderBlk = getReviewHeaderBlk();
    let defaultBlk = getReviewDefaultBlk();
    let formBodyblk = getReviewBodyBlk();
    $("#form-preview").html([formHeaderBlk, defaultBlk, formBodyblk]);
}

function getReviewHeaderBlk() {
    return `<div class="row><div class="col-sm-12"><h4>${outputData.formTitle ? outputData.formTitle : "Please Enter Form Title"}<button class="btn btn-success btn-sm pull-right" type="button" onClick="saveOrUpdateForm()">${formId ? 'Update' : 'Create'}</button><button class="btn btn-danger btn-sm pull-right" type="button" onClick="resetForm()">Reset</button></h4><p>${outputData.formDes ? outputData.formDes : "Please Enter Form Description"}</p></div></div><hr/>`;
}
function getReviewDefaultBlk() {
    return `<div class="row"><div class="col-sm-6 col-md-4 divcols"><label>First</label><input type="text" class="form-control" name="first_name" id="first_name" placeholder="First name"></div><div class="col-sm-6 col-md-4 divcols"><label>Middle</label><input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Middle name"></div><div class="col-sm-6 col-md-4 divcols"><label>Last</label><input type="text" class="form-control" name="last_name" placeholder="Last name"></div><div class="col-sm-12 col-md-12"><label>Email</label><input type="email" class="form-control" name="email" placeholder="Mail Id"></div></div>`
}

function getReviewBodyBlk() {
    let reviewBlk = outputData.elObject.map(function (item) {
        if (item.type == 1) {
            if (item.title === "Phone" || item.title === "Social Profile") {
                return `<div class="row"><div class="col-sm-12"><label>${item.title}</label><input type="text" name="${item.tag}" class="form-control" placeholder="${item.title}"></div></div>`
            } else if (item.title === "Address") {
                return `<div class="col-sm-12"><div class="row" tyle="padding:10px;"><div class="col-sm-6"><label>Street Address</label><input type="text" name="${item.tag}" class="form-control" placeholder="Street Address"></div><div class="col-sm-5"><label>Apt/unit/box</label><input type="text" name="${item.tag}" class="form-control" placeholder="Door / Apartment Address"></div></div><div class="row"><div class="col-sm-4"><label>City</label><input type="text" name="${item.tag}" class="form-control" placeholder="City Name"></div><div class="col-sm-4"><label>State</label><input type="text" name="${item.tag}"  class="form-control" placeholder="State Name"></div><div class="col-sm-3"><label>Zip Code</label><input type="text" name="${item.tag}" class="form-control" placeholder="Zip / Postal Code"></div></div></div>`;
            } else if (item.title === "Birthday") {
                return `<div class="row"><div class="col-sm-12"><label>${item.title}</label><input type="date" name="${item.tag}" class="form-control" placeholder="dd/mm/yyyy"></div></div>`
            } else if (item.title === "Medical Note") {
                return `<div class="row"><div class="col-sm-12"><label>${item.title}</label><textarea placeholder="Medical Note" class="form-control"></textarea></div></div>`
            } else if (item.title === "Marital Status") {
                return `<div class="row"><div class="col-sm-12"><label>${item.title}</label><select name="${item.tag}" class="form-control"><option value="married">Married</option><option value="single">Single</option></select></div></div>`
            } else if (item.title === "Gender") {
                return `<div class="row"><div class="col-sm-12"><label>${item.title}</label><select name="${item.tag}" class="form-control"><option value="married">Male</option><option value="single">Female</option></select></div></div>`
            } else {
                return ""
            }
        } else {
            if (["Text", "Paragraph", "Date", "Number"].includes(item.fieldTitle)) {
                return `<div class="row"><div class="col-sm-12"><label>${item.label}</label><input type="${item.inputType}" class="form-control" name="${item.name}" placeholder="${item.placeholder}" ${item.isRequired ? 'required' : ''} ></div></div>`
            } else if (item.fieldTitle === "Select") {
                let optEls = item.options.map(function (optItem) {
                    return `<option value="${optItem.value}}">${optItem.option}</option>`;
                });
                return `<div class="row><div class="col-sm-12"><label>${item.label}</label><select name="${item.name}" class="form-control">${optEls}</select></div></div>`;
            } else if (item.fieldTitle === "Checkbox") {
                let optEls = item.options.map(function (optItem) {
                    return `<div class="col-sm-4"><input type="checkbox" class="form-control" value="${optItem.value}}" name="${item.name}">${optItem.option}</input></div>`;
                });
                return `<div class="row"><div class="col-sm-12"><label>${item.label}</label><div class="row">${optEls}</div></div></div>`
            } else if (item.fieldTitle === "Radio Button") {
                let optEls = item.options.map(function (optItem) {
                    return `<div class="col-sm-4"><input type="radio" class="form-control" value="${optItem.value}}" name="${item.name}">${optItem.option}</input></div>`;
                });
                return `<div class="row"><div class="col-sm-12"><label>${item.label}</label><div class="row">${optEls}</div></div></div>`
            } else {
                return ""
            }
        }
    });
    return reviewBlk.join('');
}

function resetForm() {
    $(".form_builder_area").empty();
    $("#formTitle").val(preDefinedData.formTitle);
    $("#formDes").val(preDefinedData.formDes);
    preDefinedData.elObject.forEach(function (item) {
        let el = (item.type == 1) ? getProfileHTMLFields(item) : getGeneralHTMLfields(item);
        $(".form_builder_area").append(el[0].outerHTML);
    });
    generateFormPreview();
    enableOrDisableProfileFields();
    getEmptyBlk();
}
function saveOrUpdateForm() {
    let apiPath = "";
    if (formId) {
        apiPath = siteUrl + '/api/settings/forms/manage/' + formId;
    } else {
        apiPath = siteUrl + '/api/settings/forms/manage';
    }
    let queryData = { data: outputData };
    let apiProps = { url: apiPath, method: 'post', queryData };
    fetchDataApi(apiProps, function (data) {
        // preDefinedData = data;
        // console.log(data);
        location.replace(`${siteUrl}/settings/forms/${data.id}/fields`)
    });
}
function getEmptyBlk() {
    if ($('.form_builder_area').children().length > 0) {
        removeEmptyBlk();
    } else {
        $(".empty-block").removeClass('d-none');
    }
}
function removeEmptyBlk() {
    $(".empty-block").addClass('d-none');
}