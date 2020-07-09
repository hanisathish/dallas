<div id="hhModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" id="hhModalTitle"></div>
      <div class="modal-body" id="hhModalBody">
        ...
      </div>
      <div class="modal-footer" id="hhModalFooter">
      </div>
    </div>
  </div>
</div>
<script>
    let houseHolds = [];
    let selectedUser = {};
    let searchedUserList = [];
    let selectedHh = [];
    let isAddHhBtnPresent = false;
    let isSelectedHhModal = false;
    let urlPath = location.pathname.split('/');
    let personal_id = urlPath[urlPath.length-1];
    let user = <?php echo json_encode($user) ?>;

    getHouseHolds();

    /**
    ** ----------------------- TEMPLATE RELATIVE HOUSEHOLD BLOCKS --------------- 
    */

    /**
    ** Initial Update Household block content in template
    */
    function getHouseHolds(){
        let apiPath = siteUrl+'/api/people/member/households/'+ personal_id;
        let apiProps = {url: apiPath, method:'get', queryData:null}
        fetchDataApi(apiProps, function(data){
            houseHolds = data;
            (houseHolds.length) ? updateHouseholdBlock() : getEmptyHouseholdBlock();
        })
    }

    /**
    ** Initial Update Household block content with No households in template
    */
    function getEmptyHouseholdBlock(){
        let card = `<div class="card">
            <div class="card-header" id="household-block-header">
               <h6> Household  <span class="float-right" onClick="openHouseholdModal()"><i class="fa fa-edit"></i></span></h6>
            </div>
            <div class="card-body text-center">
                <p><strong>${user.first_name} </strong> has not been added to a household yet.</p>
                <a onClick="openHouseholdModal()" class="btn btn-primary">Add one now</a>
            </div>
        </div>`;
        $("#household-blocks").html(card);
    }

    /**
    ** Initial Update Household block content with Households in template
    */
    function updateHouseholdBlock(){
        let cards = [];
        houseHolds.forEach(function(item, index){
            let userEls = [];
            let cardProps = { id: 'household-card'+index, class: "card" };
            let cardBodyProps = { class: "card-body" };
            let card= $("<div>", cardProps);
            let cardBody = $("<div>", cardBodyProps);
            let hhEditBtn = index === 0 ? `<span class="float-right" onClick="openHouseholdModal()"><i class="fa fa-edit"></i></span>` :'';
            let cardHead = `<div class="card-header" id="household-block-header">
                                <h6> ${item.name} ${hhEditBtn}</h6>
                            </div>`;

            item.users.forEach(function(userItem, index){
                let primaryContent = userItem.isPrimary === 1? '<i class="fa fa-star></i>' : '';
                userEl= `<p id="${'user-block'+userItem.id}"><i class="fa fa-user"></i> 
                    <a href="${personal_id === userItem.personal_id? '#' : '/people/member/'+ userItem.personal_id}" >
                        ${userItem.full_name}
                    </a>
                    ${primaryContent} 
                </p>`;
                userEls.push(userEl)
            })
            
            cardBody.append(userEls);
            card.append([cardHead, cardBody]);
            cards.push(card);
        });
        $("#household-blocks").html(cards);
    }

    
    /**
    ** ----------------------- MODAL RELATIVE HOUSEHOLD BLOCKS --------------- 
    */
    /**
    ** Opening Household Modal
    */
    function openHouseholdModal(){
        searchedUserList=[];
        generateModalContent();
        $("#hhModal").modal("show");
    }

    /**
    ** Initial Houlsehold Content in Modal
    */
    function generateModalContent(){
        if(houseHolds.length === 1){
            selectedHh = houseHolds[0]
            updateModalWithSelectedHh();
        }else if(houseHolds.length > 1){
            isAddHhBtnPresent = true;
            updateModalWithHhList();
        }else{
            modalContentWithEmptyHh()
        }
    }

    /**
    ** Updating Selected Household content in Modal with create New Hh button
    */
    function updateModalWithSelectedHh(hhIndex = -1){
        if(hhIndex >= 0){
            selectedHh = houseHolds[hhIndex];
        }
        let modal_title = `<h5 class="modal-title">${selectedHh.name}</h5>
                            <button type="button" class="btn btn-primary pull-right font-size-8" onClick="updateModalWithHhList()">
                                Other Households
                            </button>`;
        let modal_body = generateSelectedHhContent();
        let modal_footer = `<button type="button" class="btn btn-outline-danger" onClick="removeHousehold()">Remove Household</button>
                            <button type="button" class="btn btn-light" onClick="closeModal()">Close</button>
                            <button type="button" class="btn btn-success" onClick="saveSectedhh()">Save</button>`
        isSelectedHhModal = true;
        updateModalContent(modal_title, modal_body, modal_footer, false);
    }

    /**
    ** Listing Households and create new Household blocks in Modal 
    */
    function updateModalWithHhList(){
        isSelectedHhModal = false;
        selectedHh = [];
        /** Check already Households present or not
        * if present listting houlsehold with respective users and search bar for create New Hh
        * else simple text with search bar for cheate new Hh
        **/
        if(houseHolds.length > 0){
            newHhWithHhList();
        }else {
            newHhWithoutHhlist();
        }
    }

    /**
    ** update content with No Households in Modal
    */
    function modalContentWithEmptyHh(){
        isSelectedHhModal = false;
        let modal_title = `<h5 class="modal-title"><span>${(user.first_name)? user.first_name: 'Your'}'s Households</span><h5>`;
        let modal_body = `<h5>No HouseHold</h5>
                            <p>${user.first_name? user.first_name: 'Your'}'s profile has not added to a household yet.</p>
                            <button type="button" class="btn btn-primary" onClick="updateModalWithHhList()">add a household</button>`
        let modal_footer = `<button type="button" class="btn btn-secondary" onClick="closeModal()">Close</button>`;
        
        updateModalContent(modal_title, modal_body, modal_footer, true);
    }

    /**
    ** Listing all households with relative users and Create new household block 
    */
    function newHhWithHhList(){
        isSelectedHhModal = false;
        let modal_title = `<h5 class="modal-title">${(user.first_name)? user.first_name: 'Your'}'s Households</h5>`;
        let modal_body = getHhListBlockForModalBody();
        let modal_footer = `<button type="button" class="btn btn-secondary" onClick="closeModal()">Close</button>`
        
        updateModalContent(modal_title, modal_body, modal_footer, false);
    }

    /**
    ** Create New Hh with Hh List in Modal
    */
    function newHhWithoutHhlist(){
        isSelectedHhModal = false;
        let modal_title = `<h5 class="modal-title">${(user.first_name)? user.first_name: 'Your'}'s Households</h5>`;
        let modal_body = $('<div>', { class:"input-group"});
        let search_usr_title = getSearchUserTitle();
        let searchBlockEls = getSearchBlock();
        let content_block = [search_usr_title];
        let content_data = content_block.concat(searchBlockEls);
        modal_body.append(content_data);
        let modal_footer = `<button type="button" class="btn btn-secondary" onClick="closeModal()">Close</button>`

        updateModalContent(modal_title, modal_body, modal_footer, false);
    }

    function pickedUserFromSearchList(index){
        if(isSelectedHhModal){
            let searchStr = $("#searchStr").val()
            let selectedUsr = searchedUserList[index];
            selectedUsr.isPrimary = 2;
            selectedHh.users.push(selectedUsr);
            searchedUserList.splice(index, 1);
            generateSelectedHhContent();
            updateSearchUsrList();
            hideHhListSearchBtn();
            $("#searchStr").val(searchStr);
            return ;
        };
        selectedUser = searchedUserList[index];
        $("#hhModalBody").addClass("text-center");
        let modal_title = `<h5 class="modal-title">Join a Household of ${selectedUser.full_name}</h5> `;
        
        let modal_body = `<a href="#" onClick="crateHousehold()"><i class="fa fa-plus" aria-hidden="true"></i> Create a new houlsehold with ${selectedUser.full_name} with ${user.full_name} as members</a>`;
        let modal_footer = `<button type="button" class="btn btn-secondary" onClick="closeModal()">Close</button>`
        
        updateModalContent(modal_title, modal_body, modal_footer, false);
    }

    function hideHhUserSettingBlock(appendIds){
        let settingId = "#hhUserSetting"+appendIds;
        let settingBlockId = "#hhUserSettingBlock"+appendIds;
        $(settingId).removeClass('d-none');
        $(settingBlockId).addClass('d-none');
    }
    
    function showHhUserSettingBlock(appendIds){
        let settingId = "#hhUserSetting"+appendIds;
        let settingBlockId = "#hhUserSettingBlock"+appendIds;
        $(settingId).addClass('d-none');
        $(settingBlockId).removeClass('d-none');
    }

    function changePrimary(userId){
        selectedHh.users = selectedHh.users.map(function(item){
            item.isPrimary = (userId === item.id) ? 1 : 2;
            return item;
        });
        updateModalWithSelectedHh();
    }

    function removeHhUser(userIndex){
        let hhUser = selectedHh.users[userIndex]
        let confirmed = confirm("Are You sure you'd like to remove " + hhUser.full_name);
        if(confirmed){
            selectedHh.users.splice(userIndex, 1);
            updateModalWithSelectedHh();
        }
    }

    // Filter Data to createa New Household with selected User as member
    function filterNewHhDetails(){
        let newHhName = "";
        if(user.full_name){
            newHhName = user.full_name + ' Household';
        }else {
            newHhName = "Yours Household";
        }
        let queryData = {hhName:newHhName, primary_user: user.id, user: selectedUser.id};
        return queryData;
    }

    //Create New User Button
    function getCreateUserBtn(){
        let btn = `<div id='create-user' class="d-none">
                        <a href="/people/member/management" class="btn btn-primary d-none">Create New User <i class="fa fa-user"></i></a>
                    </div>`;
        return btn;
    }

    // Search Result Users list block
    function getSearchUserListEl(){
        let el = `<div id="search-users-list" class="list-group .vh-overflow-80 " style="width:100%"></div>`;
        return el;
    }

    // Search input element
    function getSearchInputEl(){
        let inputEl = `<input type="text" class="input-lg" style="width:100%; padding:5px" id="searchStr" value="" onInput="getSearchResults()" placeholder="Search for someone...">`;
        return inputEl;
    }

    // Getting full search block
    function getSearchBlock(){
        let content_input = getSearchInputEl();
        let search_users = getSearchUserListEl();
        let create_new_user_btn = getCreateUserBtn();
        let block = [content_input, search_users, create_new_user_btn]
        return block;
    }

    /**
    * Search user block title to create a new Hh 
    */
    function getSearchUserTitle(){
        let searchUserTitle = `<div class="input-group-prepend">
                                    <p>Whose HouseHold would you like ${user.first_name} to Join?</p>
                                </div>`;
        return searchUserTitle;
    }

    /**
    ** Updating content in modal
    */
    function updateModalContent(header, body, footer, isContentCenter=false){
        if(isContentCenter){
            $("#hhModalBody").addClass('text-center');
        }else {
            $("#hhModalBody").removeClass('text-center');
        }
        $("#hhModalTitle").html(header);
        $("#hhModalBody").html(body);
        $('#hhModalFooter').html(footer);
    }

    /**
    ** Closing Modal and Updating Household block content in template
    */
    function closeModal(){
        $("#hhModal").modal("hide");
        (houseHolds.length) ? updateHouseholdBlock() : getEmptyHouseholdBlock();
    }

    /**
    ** Editing Household Name
    */
    function updateHhName(){
        selectedHh.name = $("#hhInputName").val();
    }

    /**
    ** ------------------------ MODAL CONTENT SUPPORTED FUNCTION --------------
    */

    // generating Modal body for Household List
    function getHhListBlockForModalBody(){
        let modal_content = getHhListForModal();
        let searchBlock = $("<div>", { class: "list-group d-none", id:"showSearchBlock" });
        let toggleBtn = `<p id="hhListSearchBtn">
                            <button class="btn btn-primary" onClick="hideHhListSearchBtn()" type="button">
                                add a household
                            </button>
                        </p>`;
        let search_usr_title = getSearchUserTitle();
        let searchBlockEls = getSearchBlock();
        searchBlock.append(search_usr_title);
        searchBlock.append(searchBlockEls);
        
        let modal_body = [modal_content, toggleBtn, searchBlock];
        return modal_body;
    }
    
    // Household List Modal content
    function getHhListForModal(){
        let hhRecords = $("<div>", { class: "list-group" });
        houseHolds.forEach(function(item, index){
            let hhUsrImagesBlock = $("<div>");
            let hhUsrImages = "";
            item.users.forEach(function(usr){
                let image = null;
                if(usr.profile_pic){
                    image = `<img src="${usr.profile_pic}" height="42" width="42" style="margin:10px;" title="${usrName}" class="rounded-circle">`;
                } else {
                    image = `<span title="${usr.full_name}" style="font-size:42px; margin:10px;"><i class="fa fa-user"></i></span>`
                }
                hhUsrImages += image;
            });
            hhUsrImagesBlock.append(hhUsrImages)
            let block = `<div class="list-group-item">
                            <h6 class="hover-focus" onClick="updateModalWithSelectedHh(${index})">${item.name}</h6>
                            <div id="hhUserImagesBlk"></div>${hhUsrImages}
                        </div>`;
            $("#hhUserImagesBlk").append(hhUsrImages);
            hhRecords.append(block);
        })
        return hhRecords;
    }

    // generating Selected Household Content
    function generateSelectedHhContent(){
        let editHhName = `<div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Household :</span>
                            </div>
                            <input class="form-control" id="hhInputName" value="${selectedHh.name}" onInput="updateHhName()" />
                        </div>`;
        
        let body_content = [editHhName];
        selectedHh.users.forEach(function(item, index){
            let primaryBadge = item.isPrimary === 1 ? `<span class="badge badge-pill badge-primary" onClick="changePrimary(${item.id})">Primary</span>`: '';
            let primaryBtn = item.isPrimary !== 1 ? `<button type="button" class="btn btn-sm btn-outline-success font-size-8" onClick="changePrimary(${item.id})" >Make Primary</button>`: '';
            let block = `<div class="list-group-item">
                            <h6 class="no-margin">${item.full_name} ${primaryBadge} 
                            <button id="${'hhUserSetting'+item.id}" class="pull-right" onClick="showHhUserSettingBlock('${item.id}')"><i class="fa fa-cog"></i></button>
                            </h6>
                            <p class="text-muted no-padding no-margin">${item.email}</p>
                            <div id="${'hhUserSettingBlock'+item.id}" class="bg-light d-none" style="margin-top:12px;">
                                <button type="button" class="btn btn-sm btn-outline-danger font-size-8" onClick="removeHhUser(${index})">Remove</button>
                                ${primaryBtn}
                                <button type="button" class="btn-sm rounded pull-right font-size-8" onClick="hideHhUserSettingBlock('${item.id}')"><i class="fa fa-cog"></i> close</button>  
                            </div>
                        </div>`;
            body_content.push(block);
        });
        let searchBlock = $("<div>", { class: "list-group d-none", id:"showSearchBlock" });
        let toggleBtn = `<p id="hhListSearchBtn">
                            <button class="btn btn-primary" onClick="hideHhListSearchBtn()" type="button">
                                add a User
                            </button>
                        </p>`;
        let searchBlockEls = getSearchBlock();
        body_content.push(toggleBtn)
        searchBlock.html(searchBlockEls);
        
        // body_content.concat()

        body_content.push(searchBlock)
        if(isSelectedHhModal){
            $("#hhModalBody").html(body_content);
            return ;
        }
        return body_content;
    }

    /**
    ** Listing user search records
     */
    function updateSearchUsrList(){
        $("#hhModalBody").removeClass("text-center");
         let records = [];
        if(searchedUserList.length > 0){
            searchedUserList.forEach(function(item, index){
                let block = `<div class="list-group-item list-group-item-action hover-focus"
                                 onClick="pickedUserFromSearchList(${index})">
                                <h6 class="no-margin">${item.full_name}</h6>
                                <p class="text-muted no-padding no-margin">
                                    ${item.mobile_no? item.mobile_no: "No Mobile Number"}
                                </p>
                                <p class="text-muted no-padding no-margin">${item.email}</p>
                                <p class="text-muted no-padding no-margin">${item.address}</p>
                            </div>`;
                records.push(block);
            })
        }else {
            let noRecord = `<p>No records found</p>`;
            records.push(noRecord);
        }
        let createUserBtn = `<a href="/people/member/management" type="button" class="btn btn-secondary btn-lg btn-block">
                             <i class="fa fa-user"></i> Create A New Person</a>`
        records.push(createUserBtn);
        $("#search-users-list").html(records);
    }
    /**
    ** SUPPORTED FUNCTIONS
    */

    function hideHhListSearchBtn(){
        $("#hhListSearchBtn").addClass('d-none');
        $("#showSearchBlock").removeClass('d-none');
    }

    /** 
    ** ------------------ API RELATIVE FUNCTIONS AND API CALL -----------------
    **/ 
    
    // Get Search Users list for search query from API
    function getSearchResults(){
        let searchStr = $("#searchStr").val();
        let exceptIds = null
        if(isSelectedHhModal){
            exceptIds = selectedHh.users.map(function(item){
                return item.id;
            })
        }else {
            exceptIds = [user.id];
        }
        searchedUserList = [];
        if(searchStr.length > 1){
            let apiPath = siteUrl+'/api/people/member/households/get-users-search';
            let apiProps = {url: apiPath, method:'post', queryData:{searchStr, exceptIds}}
            fetchDataApi(apiProps, function(data){
                searchedUserList = data.filter(function(item){
                                    return !exceptIds.includes(item.id);
                                });
                updateSearchUsrList();
            })
        }else {
            $("#search-users-list").html("<div></div>");
        }
    }

    // Remove Household and closing Modal
    function removeHousehold(){
        let apiPath = siteUrl+'/api/people/member/households/remove-household';
        let apiProps = {url: apiPath, method:'post', queryData:{hhId: selectedHh.id}};
        let hhIndex = houseHolds.findIndex(function(item, index){
            return item.id === selectedHh.id;
        });
        houseHolds.splice(hhIndex, 1);
        selectedHh = [];
        closeModal();
        fetchDataApi(apiProps, function(data){
            console.log(data);
        })
    }

    // Creating new household
    function crateHousehold(){
        let queryData = filterNewHhDetails();
        let apiPath = siteUrl+'/api/people/member/households/create-new';
        let apiProps = {url: apiPath, method:'post', queryData}
        fetchDataApi(apiProps, function(data){
            houseHolds.push(data);
            selectedHh = data;
            updateModalWithSelectedHh();
        })
    }

    // Save or Update the Househould
    function saveSectedhh(){
        selectedHh.name = selectedHh.name.length < 2? "household" : selectedHh.name;
        if(selectedHh.users.length > 0){
            let isUserPresent = selectedHh.users.find(function(item, index){
                                    return item.id === user.id;
                                });
            if(isUserPresent){
                let hhIndex = houseHolds.findIndex(function(item, index){
                                return item.id === selectedHh.id;
                            });
                houseHolds.splice(hhIndex, 1, selectedHh);
                let apiPath = siteUrl+'/api/people/member/households/update-household';
                let queryData = {household: selectedHh};
                let apiProps = {url: apiPath, method:'post', queryData};
                closeModal();
                fetchDataApi(apiProps, function(data){
                    console.log(data);
                })
            } else {
                removeHousehold();
                return;
            }
        }else {
            removeHousehold();
        }
    }
    // Calling Restfull Api's
    function fetchDataApi(props, callback){
        let payload = {};
        if(props.method == 'post'){
            payload = {
                method: props.method,
                body: props.method === 'post' ? JSON.stringify(props.queryData) : ''
            }
        }
        fetch(props.url, payload).then(
            function(response) {
            if (response.status !== 200) {
                throw new Error("failure with error code"+response.status)
            }
            response.json().then(function(data) {
                return callback(data);
            });
            }
        )
        .catch(function(err) {
            console.log('Fetch Error :-S', err);
        });
    }
</script>