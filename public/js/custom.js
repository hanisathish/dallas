function getConfirmation(title, body_content, cb){
    let cModal = `<div id="confirmationModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header" id="cModalTitle">dfdfdsa fds</div>
            <div class="modal-body" id="cModalBody">
            </div>
            <div class="modal-footer" id="cModalFooter">
                <button class="btn btn-danger cReject">Cancel</button>
                <button class="btn btn-success cAccept">Accept</button>
            </div>
            </div>
        </div>
    </div>`;
    $(document.body).append(cModal);
    $("#cModalTitle").html(`<h6>${title}</h6>`);
    $("#cModalBody").html(body_content);

    $("#confirmationModal").modal("show");

    $(document).on("click", ".cReject", function(){
        $("#confirmationModal").modal("hide");
        cb(false);
    });

    $(document).on("click", ".cAccept", function(){
        $("#confirmationModal").modal("hide");
        // $("#confirmationModal").remove();
        cb(true);
    });
}

function getTimeValues(){
    let timeData = []
    let stamps = ['AM', 'PM'];
    stamps.forEach(function(stamp){
        for (let i = 1; i <= 9; i++) timeData.push({value:`${(stamp=='PM')? i+12+':00:00' : '0'+i+':00:00'}`, label: `0${i}:00 ${stamp}`}) ;
        for(let i = 10; i <=11; i++) timeData.push({value:`${(stamp=='PM')? i+12+':00:00' : i+':00:00'}`, label: `${i}:00 ${stamp}`});
        timeData.push({value:`${(stamp=='PM')? '00:00:00' : '12:00:00'}`, label: `12:00 ${(stamp == 'AM')? 'PM': 'AM'}`});
    });
    return timeData;
}

function appendModalToBody(modalId){
    let modalEl = `<div id='${modalId}' class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-backdrop="static">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header modalTitle"></div>
                                <div class="modal-body modalBody"></div>
                                <div class="modal-footer modalFooter"></div>
                            </div>
                        </div>
                    </div>`;
    $(document.body).append(modalEl);
}