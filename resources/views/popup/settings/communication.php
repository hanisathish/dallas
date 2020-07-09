<div id="settingCommunication" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" id="commTitle">
                <h3 id="body_title"></h3>
            </div>
            <div class="modal-body" id="commBody">
                <div class="row">
                    <form action="#">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Template Name :</span>
                            </div>
                            <input class="form-control" id="templateNameInput"/>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="padding-right: 30px;">Template Sub:</span>
                            </div>
                            <input class="form-control" id="templateSubjectInput"/>
                        </div>
                        <textarea id="templateBodyInput" name="area"></textarea>
                    </form>
                </div>
            </div>
            <div class="modal-footer" id="hhModalFooter">
                <button class="btn btn-success" onClick="saveTemplate()">Save</button>
                <button class="btn btn-danger" onClick="cancelEditTemplate()">Cancel</button>
            </div>
        </div>
    </div>
</div>