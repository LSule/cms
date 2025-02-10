<div class="modal fade" style="display: show"; id="modal-detail" tabindex="-1" aria-labelledby="contact-pop-up" */>
            <div class="modal-dialog modal-fullscreen bg-white">
                <div class="modal-content">
                    <div class="modal-header row px-3">

                            <div class="col-10">
                                    <button 
                                    id="close-modal"
                                    type="button" 
                                    class="btn btn-secondary btn-sm rounded-circle " data-bs-dismiss="modal" 
                                    aria-label="Close">
                                    <i class="fa-solid fa-backward">
                                    </i></button>
                            </div>
                            <div class="col-2">
                                    <button 
                                    type="button" 
                                    class="rounded-3 border-0 text-white bg-secondary px-3 float-end" form="contact-info" 
                                    id="edit_btn" 
                                    >Edit</button></div>
                            </div>
                        <form id="contact-info" style="display: show"; class="modal-body container ">
                            <!-- title of contact card-->
                             <input class="text-center form-control form-control-lg fs-1 border-0 bg-white" 
                                data-id="<?= $contact_id ?>" 
                                id="edit-name" 
                                disabled="true" 
                                value="<?= $contact_fullname ?>">
                            </input>
                            
                            <div class="fs-3">Mobile</div>         
                                <input id="edit-mobile" 
                                    type="text" 
                                    class="fs-3 mb-3 text-info border-0" 
                                    value="<?= $contact_mobile ?>" 
                                    disabled="true">
                                </input>         

                            <div class="fs-3 ">Email</div>         
                                <input id="edit-email" 
                                    type="email" 
                                    class="fs-3 mb-3 text-info border-0" 
                                    value="<?= $contact_email ?>" 
                                    disabled="true">
                                </input>         

                            <div class="fs-3">Company</div>    
                                <input id="edit-company" 
                                    type="text" 
                                    class="fs-3 mb-5 fw-bold border-0" 
                                    value="<?= $contact_company ?>" 
                                    disabled="true">
                                </input>  

                                <div id="btn-del-holder" class=" w-100 h-" style="display: none;">
                                    <div class="col-8 offset-2">
                                        <button
                                            id="delete-btn"
                                            type="button"
                                            class="btn btn-warning w-100 mt-5">
                                            Delete Contact
                                        </button>
                                    </div>
                                </div>

                                <div id="btn-verification" class=" w-100 h-50 " style="display: none;">
                                    <div class="col-8 offset-2">
                                        <button
                                            id="real-del-btn"
                                            type="button"
                                            class="btn btn-light w-100 mt-5 text-danger">
                                            Delete Contact
                                        </button>
                                        <button
                                            id="cancel-btn"
                                            type="button"
                                            class="btn btn-light w-100 mt-5 text-info">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                             </Form>    
                    
        </div>