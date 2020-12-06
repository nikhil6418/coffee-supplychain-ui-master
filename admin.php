<?php include('templates/_header.php'); ?>


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <!-- <h4 class="page-title">Dashboard</h4> -->
        </div>
        <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        </div> -->
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info" id="divOngoingTransaction" style="display: none">Ongoing Transaction: <span id="linkOngoingTransaction">None</span> </div>
        </div>
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-4 col-sm-6 ">
            <div class="white-box">
                <h3 class="box-title">Users</h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-user text-info"></i></li>
                    <li class="text-right"><span class="counter text-info" id="totalUsers">0</span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 ">
            <div class="white-box">
                <h3 class="box-title">Total Roles</h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-graduation text-purple"></i></li>
                    <li class="text-right "><span class="counter text-purple">5</span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 ">
            <div class="white-box">
                <h3 class="box-title">Total Batches</h3>
                <ul class="list-inline two-part">
                    <li><i class="icon-doc text-success"></i></li>
                    <li class="text-right"><span class="counter text-success" id="totalBatch">0</span></li>
                </ul>
            </div>
        </div>
    </div>
    <!--row -->
    <!-- /.row -->


    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="white-box">
                <a href="javascript:void(0);" class="btn btn-info pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light" onclick="javascript:$('#batchFormModel').modal();">Create Batch</a>
                <h3 class="box-title">Batches Overview</h3>
                <div class="table-responsive">
                    <table class="table product-overview" id="adminCultivationTable">
                        <thead>
                            <tr>
                                <th>Batch ID</th>
                                <th>QR-Code</th>
                                <th>Farm Inspector</th>
                                <th>Harvester</th>
                                <th>Exporter</th>
                                <th>Importer</th>
                                <th>Processor</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" align="center">No Data Available</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Your Address <i class="fa fa-qrcode fa-2x text-success"></i></h3>
                <ul class="list-inline two-part">
                    <li class="text-right" id="currentUserAddress">0x0000000000000000000000000000000000000000</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Storage Contract Address <i class="fa fa-qrcode fa-2x text-danger"></i></h3>
                <ul class="list-inline two-part">
                    <li class="text-right" id="storageContractAddress">0x0000000000000000000000000000000000000000</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Coffee Supplychain Contract Address <i class="fa fa-qrcode fa-2x text-info"></i></h3>
                <ul class="list-inline two-part">
                    <li class="text-right" id="coffeeSupplychainContractAddress">0x0000000000000000000000000000000000000000</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">User Contract Address <i class="fa fa-qrcode fa-2x text-info"></i></h3>
                <ul class="list-inline two-part">
                    <li class="text-right" id="userContractAddress">0x0000000000000000000000000000000000000000</li>
                </ul>
            </div>
        </div>
    </div>

    <!--row -->
    <div class="row">
        <div class="col-md-12 col-lg-4 col-sm-12">
            <div class="white-box">
                <h3 class="box-title">User Roles</h3>
                <div class="table-responsive">
                    <table class="table product-overview">
                        <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Role Slug</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Farm Inspection</td>
                                <td><span class="label label-info font-weight-100">FARM_INSPECTION</span></td>
                            </tr>
                            <tr>
                                <td>Harvester</td>
                                <td><span class="label label-success font-weight-100">HARVESTER</span></td>
                            </tr>
                            <tr>
                                <td>Exporter</td>
                                <td><span class="label label-warning font-weight-100">EXPORTER</span></td>
                            </tr>
                            <tr>
                                <td>Importer</td>
                                <td><span class="label label-danger font-weight-100">IMPORTER</span></td>
                            </tr>
                            <tr>
                                <td>Processor</td>
                                <td><span class="label label-primary font-weight-100">PROCESSOR</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-8 col-sm-12">
            <div class="white-box">
                <a href="javascript:void(0);" id="userFormClick" class="btn btn-info pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">Create User</a>
                <h3 class="box-title">Users</h3>
                <div class="table-responsive">
                    <table class="table product-overview table-responsive" id="tblUser">
                        <thead>
                            <tr>
                                <th>User Address</th>
                                <th>Name</th>
                                <th>Contact No.</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->

<div id="batchFormModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; padding-top: 170px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Add Batch</h2>
            </div>
            <div class="modal-body">
                <form id="batchForm" onsubmit="return false;">
                    <fieldset style="border:0;">
                        <div class="form-group">
                            <label class="control-label" for="farmerRegistrationNo">Farmer Registration No <i class="red">*</i></label>
                            <input type="text" class="form-control" id="farmerRegistrationNo" name="farmerRegistrationNo" placeholder="Registration No" data-parsley-required="true">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="farmerName">Farmer Name <i class="red">*</i></label>
                            <input type="text" class="form-control" id="farmerName" name="farmerName" placeholder="Farmer Name" data-parsley-required="true">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="farmerAddress">Farmer Address <i class="red">*</i></label>
                            <textarea class="form-control" id="farmerAddress" name="farmerAddress" placeholder="Farmer Address" data-parsley-required="true"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="exporterName">Exporter Name <i class="red">*</i></label>
                            <input type="text" class="form-control" id="exporterName" name="exporterName" placeholder="Exporter Name" data-parsley-required="true">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="importerName">Importer Name <i class="red">*</i></label>
                            <input type="text" class="form-control" id="importerName" name="importerName" placeholder="Importer Name" data-parsley-required="true">
                        </div>
                    </fieldset>

            </div>
            <div class="modal-footer">
                <button type="submit" onclick="addCultivationBatch();" class="fcbtn btn btn-primary btn-outline btn-1f">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="userFormModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; padding-top: 170px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title" id="userModelTitle">Add User</h2>
            </div>
            <div class="modal-body">
                <form id="userForm" onsubmit="return false;">
                    <fieldset style="border:0;">
                        <div class="form-group">
                            <label class="control-label" for="userWalletAddress">User Wallet Address <i class="red">*</i></label>
                            <input type="text" class="form-control" id="userWalletAddress" name="userWalletAddress" placeholder="Wallet Address" data-parsley-required="true" minlength="42" maxlength="42">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="userName">User Name <i class="red">*</i></label>
                            <input type="text" class="form-control" id="userName" name="userName" placeholder="Name" data-parsley-required="true">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="userContactNo">User Contact <i class="red">*</i></label>
                            <input type="text" class="form-control" id="userContactNo" name="userContactNo" placeholder="Contact No." data-parsley-required="true" data-parsley-type="digits" data-parsley-length="[10, 15]" maxlength="15">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="userRoles">User Role <i class="red">*</i></label>
                            <select class="form-control" id="userRoles" name="userRoles" data-parsley-required="true">
                                <option value="">Select Role</option>
                                <option value="FARM_INSPECTION">Farm Inspection</option>
                                <option value="HARVESTER">Harvester</option>
                                <option value="EXPORTER">Exporter</option>
                                <option value="IMPORTER">Importer</option>
                                <option value="PROCESSOR">Processor</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="isActive">User Status</label>
                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" id="isActive" name="isActive" data-size="small" />
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="userProfileHash">Profile Image <i class="red">*</i></label>
                            <input type="file" class="form-control" onchange="handleFileUpload(event);" />
                            <input type="hidden" class="form-control" id="userProfileHash" name="userProfileHash" placeholder="User Profile Hash" data-parsley-required="true">
                            <span id="imageHash"></span>
                        </div>
                    </fieldset>

            </div>
            <div class="modal-footer">
                <i style="display: none;" class="fa fa-spinner fa-spin"></i>
                <button type="submit" onclick="userFormSubmit();" class="fcbtn btn btn-primary btn-outline btn-1f" id="userFormBtn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var batchFormInstance, userFormInstance;

    $(window).on('coinbaseReady', function() {
        getUserEvents(globUserContract);
        getCultivationEvents(globMainContract);
    });

    $(document).ready(function() {
        userFormInstance = $("#userForm").parsley();
        batchFormInstance = $("#batchForm").parsley();

        initSwitch();
    });

    function initSwitch() {
        /*For User Form Pop Up*/
        new Switchery($("#isActive")[0], $("#isActive").data());
    }

    function userFormSubmit() {

        if ($("form#userForm").parsley().isValid()) {

            var userWalletAddress = $("#userWalletAddress").val();
            var userName = $("#userName").val();
            var userContactNo = $("#userContactNo").val();
            var userRoles = $("#userRoles").val();
            var isActive = $("#isActive").is(":checked");
            var userImageAddress = $("#userProfileHash").val();

            globUserContract.methods.updateUserForAdmin(userWalletAddress, userName, userContactNo, userRoles, isActive, userImageAddress)
                .send({
                    from: globCoinbase,
                    to: globUserContract._address
                })
                .on('transactionHash', function(hash) {
                    handleTransactionResponse(hash);
                    $("#userFormModel").modal('hide');
                })
                .on('receipt', function(receipt) {
                    receiptMessage = "User Created Successfully";
                    handleTransactionReceipt(receipt, receiptMessage);
                    $("#userFormModel").modal('hide');
                    getUserEvents(globUserContract);
                })
                .on('error', function(error) {
                    handleGenericError(error.message);
                    return;
                });
        }
    }

    function addCultivationBatch() {

        if (batchFormInstance.validate()) {
            var farmerRegistrationNo = $("#farmerRegistrationNo").val().trim();
            var farmerName = $("#farmerName").val().trim();
            var farmerAddress = $("#farmerAddress").val().trim();
            var exporterName = $("#exporterName").val().trim();
            var importerName = $("#importerName").val().trim();

            globMainContract.methods.addBasicDetails(farmerRegistrationNo, farmerName, farmerAddress, exporterName, importerName)
                .send({
                    from: globCoinbase,
                    to: globMainContract._address
                })
                .on('transactionHash', function(hash) {
                    handleTransactionResponse(hash);
                    $("#batchFormModel").modal('hide');
                })
                .on('receipt', function(receipt) {
                    receiptMessage = "Token Transferred Successfully";
                    handleTransactionReceipt(receipt, receiptMessage);
                    $("#batchFormModel").modal('hide');
                    getCultivationEvents(globMainContract);
                })
                .on('error', function(error) {
                    handleGenericError(error.message);
                    return;
                });
        }
    }


    function getCultivationEvents(contractRef) {
        contractRef.getPastEvents('PerformCultivation', {
            fromBlock: 0
        }).then(function(events) {
            $("#totalBatch").html(events.length);

            var finalEvents = [];
            $.each(events, function(index, elem) {
                var tmpData = {};
                tmpData.batchNo = elem.returnValues.batchNo;
                tmpData.transactionHash = elem.transactionHash;
                getBatchStatus(contractRef, tmpData.batchNo).then(result => {
                    tmpData.status = result;

                    finalEvents.push(tmpData);
                });
            });

            setTimeout(function() {
                if (finalEvents.length > 0) {
                    var table = buildCultivationTable(finalEvents);
                    $("#adminCultivationTable").find("tbody").html(table);
                    $('.qr-code-magnify').magnificPopup({
                        type: 'image',
                        mainClass: 'mfp-zoom-in'
                    });
                }

                counterInit();
            }, 1000);

        }).catch(error => {
            console.log(error)
        });
    }

    function buildCultivationTable(finalEvents) {
        var table = "";

        for (var tmpDataIndex in finalEvents) {
            var elem = finalEvents[tmpDataIndex];

            var batchNo = elem.batchNo;
            var transactionHash = elem.transactionHash;
            var tr = "";
            var url = 'https://rinkeby.etherscan.io/tx/' + transactionHash;
            var qrCode = 'https://chart.googleapis.com/chart?cht=qr&chld=H|1&chs=400x400&chl=' + url;

            var commBatchTd = `<td>` + batchNo + ` <a href="` + url + `" class="text-danger" target="_blank"><i class="fa fa-external-link"></i></a></td>`;
            var commQrTd = `<td><a href="` + qrCode + `" title="` + transactionHash + `" class="qr-code-magnify" data-effect="mfp-zoom-in">
                        <img src="` + qrCode + `" class="img-responsive" style="width:30px; height:30px;">
                    </a>
                </td>`;
            var commActionTd = `<td><a href="view-batch.php?batchNo=` + batchNo + `&txn=` + transactionHash + `" target="_blank" class="text-inverse p-r-10" data-toggle="tooltip" title="View"><i class="ti-eye"></i></a> </td>`;

            if (elem.status == "FARM_INSPECTION") {
                tr = `<tr>
                ` + commBatchTd + commQrTd + `
                <td><span class="label label-warning font-weight-100">Processing</span></td>
                <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                ` + commActionTd + `
            </tr>`;
            } else if (elem.status == "HARVESTER") {
                tr = `<tr>
                ` + commBatchTd + commQrTd + `
                <td><span class="label label-success font-weight-100">Completed</span></td>
                <td><span class="label label-warning font-weight-100">Processing</span> </td>
                <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                ` + commActionTd + `
            </tr>`;
            } else if (elem.status == "EXPORTER") {
                tr = `<tr>
                ` + commBatchTd + commQrTd + `
                <td><span class="label label-success font-weight-100">Completed</span></td>
                <td><span class="label label-success font-weight-100">Completed</span> </td>
                <td><span class="label label-warning font-weight-100">Processing</span> </td>
                <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                ` + commActionTd + `
            </tr>`;
            } else if (elem.status == "IMPORTER") {
                tr = `<tr>
                ` + commBatchTd + commQrTd + `
                <td><span class="label label-success font-weight-100">Completed</span></td>
                <td><span class="label label-success font-weight-100">Completed</span> </td>
                <td><span class="label label-success font-weight-100">Completed</span> </td>
                <td><span class="label label-warning font-weight-100">Processing</span> </td>
                <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                ` + commActionTd + `
            </tr>`;
            } else if (elem.status == "PROCESSOR") {
                tr = `<tr>
                ` + commBatchTd + commQrTd + `
                <td><span class="label label-success font-weight-100">Completed</span></td>
                <td><span class="label label-success font-weight-100">Completed</span> </td>
                <td><span class="label label-success font-weight-100">Completed</span> </td>
                <td><span class="label label-success font-weight-100">Completed</span> </td>
                <td><span class="label label-warning font-weight-100">Processing</span> </td>
                ` + commActionTd + `
            </tr>`;
            } else if (elem.status == "DONE") {
                tr = `<tr>
                ` + commBatchTd + commQrTd + `
                <td><span class="label label-success font-weight-100">Completed</span></td>
                <td><span class="label label-success font-weight-100">Completed</span> </td>
                <td><span class="label label-success font-weight-100">Completed</span> </td>
                <td><span class="label label-success font-weight-100">Completed</span> </td>
                <td><span class="label label-success font-weight-100">Completed</span> </td>
                ` + commActionTd + `
            </tr>`;
            }

            table += tr;
        }

        return table;

    }

    function getBatchStatus(contractRef, batchNo) {
        return contractRef.methods.getNextAction(batchNo)
            .call();

    }
</script>





<?php include('templates/_footer.php'); ?> 