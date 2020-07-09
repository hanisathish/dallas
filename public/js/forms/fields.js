let formData = {};
let formId = null;
let isSubmissionForm = false;
$(document).ready(function () {
    fetchFormData();
});

function fetchFormData() {
    let urlPath = location.pathname.split('/');
    if (urlPath.includes('submission')) {
        isSubmissionForm = true;
    }
    let form_id_hidden = $("#form_id_hidden").val();
    //if (urlPath[3] && typeof parseInt(urlPath[3]) === 'number') {
    //    formId = urlPath[3];
    if (form_id_hidden && typeof parseInt(form_id_hidden) === 'number') {
        formId = form_id_hidden;
        let apiPath = siteUrl + '/api/settings/forms/content/' + formId;
        let queryData = {};
        let apiProps = { url: apiPath, method: 'get', queryData };
        fetchDataApi(apiProps, function (data) {
            formData = data
            updateReviewBlock();
        });
    } else {
        console.error("Form Id is missing, please try later");
    }
}

function updateReviewBlock() {
    let formHeaderBlk = getReviewHeaderBlk();
    let defaultBlk = getReviewDefaultBlk();
    let formBodyblk = getReviewBodyBlk();
    let formBtns = '';
    if (isSubmissionForm) {
        formBtns = `<div class="row"><div class="col-sm-12"><button class="btn btn-ligh btn-sm pull-right m-2" type="submit" onClick="generateFormPreview()">Submit</button><button class="btn btn-danger btn-sm pull-right m-2" type="reset" >Reset</button></div></div>`
    }
    $("#form-preview").html([formHeaderBlk, defaultBlk, formBodyblk, formBtns]);
}

function getReviewHeaderBlk() {
    let links = '';
    if (!isSubmissionForm) {
        links = `<a class="btn btn-light btn-sm pull-right" type="button" href="${siteUrl + '/settings/forms/manage/' + formId}">Edit Form</a><a class="btn btn-light btn-sm pull-right" type="button" target="_blank" href="${siteUrl + '/form/submission/' + formId}">Public Form</a>`;
    }
    return `<div class="row"><div class="col-sm-12"><h4>${formData.formTitle ? formData.formTitle : "Form Title not specified"}${links}</h4><p>${formData.formDes ? formData.formDes : "Form Description not specified"}</p></div></div><hr/>`;
}
function getReviewDefaultBlk() {
    return `<div class="row mb-4"><div class="col-sm-6 col-md-4 divcols"><label>First Name</label><input type="text" data-type="1" data-block="Name" data-label="First Name" class="field_data form-control" name="first_name" id="first_name" placeholder="First name" required><div class="invalid-feedback">First Name is required.</div></div><div class="col-sm-6 col-md-4 divcols"><label>Middle Name</label><input type="text" data-type="1" data-block="Name" data-label="Middle Name" class="field_data form-control" name="middle_name" id="middle_name" placeholder="Middle name" required><div class="invalid-feedback">Middle Name is required.</div></div><div class="col-sm-6 col-md-4 divcols"><label>Last Name</label><input type="text" data-type="1" data-block="Name" data-label="Last Name" class="field_data form-control" name="last_name" placeholder="Last name"></div></div><div class="row mb-4"><div class="col-sm-12 col-md-12"><label>Email</label><input type="email" data-type="1" data-label="Mail Id" class="field_data form-control" name="email" placeholder="Mail Id" required><div class="invalid-feedback">Enter valid Mail Id.</div></div></<div>`
}

function getReviewBodyBlk() {
    let reviewBlk = formData.elObject.map(function (item) {
        $required = item.isRequired ? 'required' : ''
        if (item.type == 1) {
            if (item.title === "Phone" || item.title === "Social Profile") {
                return `<div class="row mb-4"><div class="col-sm-12"><label>${item.title}</label><input type="text" data-type="1" data-label="Phone" minlength='8' maxlength="12" name="${item.tag}" class="field_data form-control" placeholder="${item.title}" ${$required}><div class="invalid-feedback">Enter Valid Phone Number</div></div></div>`
            } else if (item.title === "Address") {
                return `<div class="col-sm-12 mb-4"><div class="row mb-4" tyle="padding:10px;"><div class="col-sm-6 pl-0"><label>Street Address</label><input type="text" name="${item.tag}" data-type="1" data-block="Address" data-label="Street Address" class="field_data form-control" placeholder="Street Address" ${$required}><div class="invalid-feedback">Enter Street Adress.</div></div><div class="col-sm-5 pr-0"><label>Apt/unit/box</label><input type="text" name="${item.tag}" data-type="1" data-block="Address" data-label="Apt" class="field_data form-control" placeholder="Door / Apartment Address" ${$required}><div class="invalid-feedback">Enter Apt/Unit/Box Adress.</div></div></div><div class="row"><div class="col-sm-4 pl-0"><label>City</label><input type="text" data-type="1" data-block="Address" data-label="City" class="field_data form-control" placeholder="City Name" ${$required}><div class="invalid-feedback">Enter valid City name.</div></div><div class="col-sm-4"><label>State</label><input type="text" data-type="1" data-block="Address" data-label="State" class="field_data form-control" placeholder="State Name" ${$required}><div class="invalid-feedback">Enter valid State name.</div></div><div class="col-sm-3"><label>Zip Code</label><input type="number" data-type="1" data-block="Address" data-label="Zip Code" min-length="4" maxlength="8" class="field_data form-control" placeholder="Zip / Postal Code" ${$required}><div class="invalid-feedback">Enter valid Postal Code.</div></div></div></div>`;
            } else if (item.title === "Birthday") {
                return `<div class="row mb-4"><div class="col-sm-12"><label>${item.title}</label><input type="date" data-type="1" data-label="${item.title}" class="field_data form-control" placeholder="dd/mm/yyyy" ${$required}><div class="invalid-feedback">Enter valid Date of Birth</div></div></div>`
            } else if (item.title === "Medical Note") {
                return `<div class="row mb-4"><div class="col-sm-12"><label>${item.title}</label><textarea placeholder="Medical Note" data-type="1" data-label="${item.title}" rows="5" minlength="20" maxlength="150" class="field_data form-control" ${$required}></textarea><div class="invalid-feedback">Enter valid Medical Report Details</div></div></div>`
            } else if (item.title === "Marital Status") {
                return `<div class="row mb-4"><div class="col-sm-12"><label>${item.title}</label><select name="${item.tag}"  data-type="1" data-label="${item.title}" class="field_data form-control" ${$required}><option value="married">Married</option><option value="single">Single</option></select><div class="invalid-feedback">Select valid option.</div></div></div>`
            } else if (item.title === "Gender") {
                return `<div class="row mb-4"><div class="col-sm-12"><label>${item.title}</label><select name="${item.tag}" data-type="1" data-label="${item.title}" class="field_data form-control" ${$required}><option value="married">Male</option><option value="single">Female</option></select><div class="invalid-feedback">Select valid option.</div></div></div>`
            } else {
                return ""
            }
        } else {
            if (["Text", "Paragraph", "Date", "Number"].includes(item.fieldTitle)) {
                return `<div class="row mb-4"><div class="col-sm-12"><label>${item.label}</label><input type="${item.inputType}" data-type="2" data-label="${item.label}" class="field_data form-control" name="${item.name}" placeholder="${item.placeholder}" ${$required}><div class="invalid-feedback">Enter valid ${item.label}.</div></div></div>`
            } else if (item.fieldTitle === "Select") {
                let optEls = item.options.map(function (optItem) {
                    return `<option value="${optItem.value}}">${optItem.option}</option>`;
                });
                return `<div class="row mb-4"><div class="col-sm-12"><label>${item.label}</label><select name="${item.name}" data-type="2" data-label="${item.label}" class="field_data form-control" ${$required}>${optEls}</select><div class="invalid-feedback">Select valid ${item.label} Option/s.</div></div></div>`;
            } else if (item.fieldTitle === "Checkbox") {
                let optEls = item.options.map(function (optItem, index) {
                    return `<div class="col-sm-4 form-check"><input id="check${optItem.option + index}" type="checkbox" data-type="2" data-label="${item.label}" class="field_data form-control-chk form-check-input form_input_req" value="${optItem.value}" name="${item.name}" ${$required} /><label class="form-check-label" for="check${optItem.option + index}">${optItem.option}</label></div>`;
                });
                return `<div class="row mb-4"><div class="col-sm-12"><label>${item.label}</label><div class="row">${optEls}</div><div class="invalid-feedback">Select valid ${item.label} Option/s.</div></div></div>`
            } else if (item.fieldTitle === "Radio Button") {
                let optEls = item.options.map(function (optItem) {
                    return `<div class="col-sm-4"><input type="radio" data-type="2" data-label="${item.label}" class="field_data form-control" value="${optItem.value}}" name="${item.name}" ${$required}>${optItem.option}</input></div>`;
                });
                return `<div class="row mb-4"><div class="col-sm-12"><label>${item.label}</label><div class="row">${optEls}</div></div><div class="invalid-feedback">Select valid ${item.label} Option.</div></div>`
            } else {
                return ""
            }
        }
    });
    return reviewBlk.join('');
}

function generateFormPreview() {
    var forms = document.getElementsByClassName('data-validation');
    Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            event.stopPropagation();
            if (form.checkValidity() !== false) {
                filterData();
            }
            form.classList.add('was-validated');
        }, false);
    })
}

function filterData() {
    let fullName = address = profileFields = generalFields = {};
    let formOutputEls = $('#form-preview .field_data');
    formOutputEls.each(function () {
        var type = $(this).attr('data-type');
        if (type == 1) {
            if ($(this).attr('data-block') && $(this).attr('data-block') == "Address") {
                address[$(this).attr('data-label')] = $(this).val();
            } else if ($(this).attr('data-block') && $(this).attr('data-block') == "Name") {
                fullName[$(this).attr('data-label')] = $(this).val();
            } else {
                profileFields[$(this).attr('data-label')] = $(this).val();
            }
        } else {
            generalFields[$(this).attr('data-label')] = $(this).val();
        }
    });
    let name = (fullName["First Name"]) ? fullName["First Name"] : '';
    name += (fullName["Middle Name"]) ? " " + fullName["Middle Name"] : '';
    name += (fullName["Last Name"]) ? " " + fullName["Last Name"] : '';
    let fullAddress = (address["Apt"]) ? address["Apt"] + ", " : '';
    fullAddress += (address["Street Address"]) ? address["Street Address"] + ", " : '';
    fullAddress += (address["City"]) ? address["City"] : '';
    fullAddress += (address["State"]) ? ", " + address["State"] : '';
    fullAddress += (address["Zip Code"]) ? " - " + address["Zip Code"] : '';
    profileFields.Name = name;
    profileFields.Address = fullAddress;
    let queryData = { orgId: formData.orgId, form_id: formId, profile_fields: profileFields, general_fields: generalFields }
    let apiPath = siteUrl + '/api/form/submission';
    let apiProps = { url: apiPath, method: 'post', queryData };
    fetchDataApi(apiProps, function (data) {
        location.reload();
    });
}