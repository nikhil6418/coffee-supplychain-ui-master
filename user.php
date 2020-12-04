<?php include('templates/_header.php'); ?>

<script type="text/javascript">
    var switchery;
    $(document).ready(function() {
        initSwitch();
        initDateTimePicker();
    });

    function initSwitch() {
        /*For User Form Pop Up*/
        switchery = new Switchery($("#isActive")[0], $("#isActive").data());
    }

    function initDateTimePicker() {
        $('.datepicker-master').datetimepicker({
            format: 'dd-mm-yyyy hh:ii:ss',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1,
            minuteStep: 1
        });
    }

    var globCurrentEditingBatchNo = false;
    var globCurrentUser = false;

    var userForm,
        farmInspectionForm,
        harvesterForm,
        exporterForm,
        importerForm,
        processingForm;

    $(document).ready(function() {

        userForm = $("#updateUserForm").parsley();
        farmInspectionForm = $("#farmInspectionForm").parsley();
        harvesterForm = $("#harvesterForm").parsley();
        exporterForm = $("#exporterForm").parsley();
        importerForm = $("#importerForm").parsley();
        processingForm = $("#processingForm").parsley();

        $('.datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: "dd-mm-yyyy"
        });
    });

    $(window).on("coinbaseReady", function() {
        getUser(globUserContract, function(data) {

            globCurrentUser = data;
            if (data.isActive == true) {
                if (data.name.trim().length <= 0 &&
                    data.contactNo.trim().length <= 0 &&
                    data.role.trim().length <= 0) {
                    swal("Oops", "Your Account was not found , Please contact Admin ", "error");
                    setTimeout(function() {
                        window.location = "index.php";
                    }, 1000);
                    return;
                }
            } else {
                swal({
                        title: "Insufficient Access",
                        text: "Your Account is blocked by Admin , Please contact to Admin",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    },
                    function(isConfirm) {
                        if (isConfirm == true) {
                            window.location = "index.php";
                        }
                    });
                return;
            }

            $("#userImage").attr('src', 'https://ipfs.io/ipfs/' + data.profileHash);
            $("#userName").html(data.name);
            $("#userContact").html(data.contactNo);
            $("#userRole").html(data.role);

        });

        getCultivationEvents(globMainContract);
    });

    /* --------------- User Section -----------------------*/
    $("#editUser").on('click', function() {
        startLoader();
        getUser(globUserContract, function(data) {

            $("#fullname").val(data.name);
            $("#contactNumber").val(data.contactNo);
            $("#role").val(data.role);

            var profileImageLink = 'https://ipfs.io/ipfs/' + data.profileHash;
            var btnViewImage = '<a href="' + profileImageLink + '" target="_blank" class=" text-danger"><i class="fa fa-eye"></i> View Image</a>';
            $("#imageHash").html(btnViewImage);

            changeSwitchery($("#isActive"), data.isActive);
            switchery.disable();
            stopLoader();
            $("#userFormModel").modal();
        });
    });

    $("#userFormBtn").on('click', function() {

        if (userForm.validate()) {
            var fullname = $("#fullname").val();
            var contactNumber = $("#contactNumber").val();
            var role = globCurrentUser.role;
            var userStatus = $("#isActive").is(":checked");
            var profileHash = $("#userProfileHash").val();

            var userDetails = {
                fullname: fullname,
                contact: contactNumber,
                role: role,
                status: userStatus,
                profile: profileHash
            };

            updateUser(globUserContract, userDetails);
        }
    });

    function getUser(contractRef, callback) {
        contractRef.methods.getUser(globCoinbase).call(function(error, result) {
            if (error) {
                alert("Unable to get User" + error);
            }
            newUser = result;
            if (callback) {
                callback(newUser);
            }
        });
    }

    function updateUser(contractRef, data) {
        contractRef.methods.updateUser(data.fullname, data.contact, data.role, data.status, data.profile)
            .send({
                from: globCoinbase,
                to: contractRef.address
            })
            .on('transactionHash', function(hash) {
                $.magnificPopup.instance.close()
                handleTransactionResponse(hash);
                $("#userFormModel").modal('hide');
            })
            .on('receipt', function(receipt) {
                receiptMessage = "User Profile Updated Succussfully";
                handleTransactionReceipt(receipt, receiptMessage);
                $("#userFormModel").modal('hide');
            })
            .on('error', function(error) {
                handleGenericError(error.message);
                return;
            });
    }

    /* --------------- Activity Section -----------------------*/

    function editActivity(batchNo) {
        startLoader();
        globCurrentEditingBatchNo = batchNo;
    }

    /* --------------- Farm Inspection Section -----------------------*/


    $("#updateFarmInspection").on('click', function() {

        if (farmInspectionForm.validate()) {
            var data = {
                batchNo: globCurrentEditingBatchNo,
                coffeeFamily: $("#coffeeFamily").val().trim(),
                typeOfSeed: $("#typeOfSeed").val().trim(),
                fertilizerUsed: $("#fertilizerUsed").val().trim(),
            };

            updateFarmInspection(globMainContract, data);
        }
    });

    function updateFarmInspection(contractRef, data) {
        //contractRef.methods.updateUser("Swapnali","9578774787","HARVESTER",true,"0x74657374")
        contractRef.methods.updateFarmInspectorData(data.batchNo, data.coffeeFamily, data.typeOfSeed, data.fertilizerUsed)
            .send({
                from: globCoinbase,
                to: contractRef.address
            })
            .on('transactionHash', function(hash) {
                $.magnificPopup.instance.close()
                handleTransactionResponse(hash);
            })
            .on('receipt', function(receipt) {
                receiptMessage = "Farm Inspection Updated Succussfully";
                handleTransactionReceipt(receipt, receiptMessage)
            })
            .on('error', function(error) {
                handleGenericError(error.message);
                return;
            });
    }

    /* --------------- Harvest Section -----------------------*/


    $("#updateHarvest").on('click', function() {

        if (harvesterForm.validate()) {
            var data = {
                batchNo: globCurrentEditingBatchNo,
                cropVariety: $("#cropVariety").val().trim(),
                temperatureUsed: $("#temperatureUsed").val().trim(),
                humidity: $("#humidity").val().trim(),
            };

            updateHarvest(globMainContract, data);
        }
    });

    function updateHarvest(contractRef, data) {
        //contractRef.methods.updateUser("Swapnali","9578774787","HARVESTER",true,"0x74657374")
        contractRef.methods.updateHarvesterData(data.batchNo, data.cropVariety, data.temperatureUsed, data.humidity)
            .send({
                from: globCoinbase,
                to: contractRef.address
            })
            .on('transactionHash', function(hash) {
                $.magnificPopup.instance.close()
                handleTransactionResponse(hash);
            })
            .on('receipt', function(receipt) {
                receiptMessage = "Harvest Updated Succussfully";
                handleTransactionReceipt(receipt, receiptMessage)
            })
            .on('error', function(error) {
                handleGenericError(error.message);
                return;
            });
    }


    /* --------------- Export Section -----------------------*/


    $("#updateExport").on('click', function() {

        if (exporterForm.validate()) {
            var tmpDate = $("#estimateDateTime").val().trim().split("-");
            tmpDate = tmpDate[1] + "/" + tmpDate[0] + "/" + tmpDate[2];

            var data = {
                batchNo: globCurrentEditingBatchNo,
                quantity: parseInt($("#quantity").val().trim()),
                destinationAddress: $("#destinationAddress").val().trim(),
                shipName: $("#shipName").val().trim(),
                shipNo: $("#shipNo").val().trim(),
                estimateDateTime: new Date(tmpDate).getTime() / 1000,
                plantNo: 0,
                exporterId: parseInt($("#exporterId").val().trim()),
            };

            updateExport(globMainContract, data);
        }
    });

    function updateExport(contractRef, data) {
        //contractRef.methods.updateUser("Swapnali","9578774787","HARVESTER",true,"0x74657374")
        contractRef.methods.updateExporterData(data.batchNo, data.quantity, data.destinationAddress, data.shipName, data.shipNo, data.estimateDateTime, data.exporterId)
            .send({
                from: globCoinbase,
                to: contractRef.address
            })
            .on('transactionHash', function(hash) {
                $.magnificPopup.instance.close()
                handleTransactionResponse(hash);
            })
            .on('receipt', function(receipt) {
                receiptMessage = "Export Updated Succussfully";
                handleTransactionReceipt(receipt, receiptMessage)
            })
            .on('error', function(error) {
                handleGenericError(error.message);
                return;
            });
    }

    /* --------------- Import Section -----------------------*/


    $("#updateImport").on('click', function() {

        if (importerForm.validate()) {
            var data = {
                batchNo: globCurrentEditingBatchNo,
                quantity: parseInt($("#quantity").val().trim()),
                shipName: $("#shipName").val().trim(),
                shipNo: $("#shipNo").val().trim(),
                transportInfo: ($("#transportInfo").val().trim()),
                warehouseName: ($("#warehouseName").val().trim()),
                warehouseAddress: ($("#warehouseAddress").val().trim()),
                importerId: parseInt($("#importerId").val().trim()),
            };

            updateImport(globMainContract, data);
        }
    });

    function updateImport(contractRef, data) {
        //contractRef.methods.updateUser("Swapnali","9578774787","HARVESTER",true,"0x74657374")
        contractRef.methods.updateImporterData(data.batchNo, data.quantity, data.shipName, data.shipNo, data.transportInfo, data.warehouseName, data.warehouseAddress, data.importerId)
            .send({
                from: globCoinbase,
                to: contractRef.address
            })
            .on('transactionHash', function(hash) {
                $.magnificPopup.instance.close()
                handleTransactionResponse(hash);
            })
            .on('receipt', function(receipt) {
                receiptMessage = "Import Updated Succussfully";
                handleTransactionReceipt(receipt, receiptMessage)
            })
            .on('error', function(error) {
                handleGenericError(error.message);
                return;
            });
    }

    /* --------------- Processor Section -----------------------*/

    $("#updateProcessor").on('click', function() {

        if (processingForm.validate()) {
            var tmpDate = $("#packageDateTime").val().trim().split("-");
            tmpDate = tmpDate[1] + "/" + tmpDate[0] + "/" + tmpDate[2];

            var data = {
                batchNo: globCurrentEditingBatchNo,
                quantity: parseInt($("#quantity").val().trim()),
                temperature: $("#processingTemperature").val().trim(),
                rostingDuration: parseInt($("#rostingDuration").val().trim()),
                internalBatchNo: ($("#internalBatchNo").val().trim()),
                packageDateTime: new Date(tmpDate).getTime() / 1000,
                processorName: ($("#processorName").val().trim()),
                processorAddress: ($("#processorAddress").val().trim()),
            };

            updateProcessor(globMainContract, data);
        }
    });

    function updateProcessor(contractRef, data) {
        //contractRef.methods.updateUser("Swapnali","9578774787","HARVESTER",true,"0x74657374")
        contractRef.methods.updateProcessorData(data.batchNo, data.quantity, data.temperature, data.rostingDuration, data.internalBatchNo, data.packageDateTime, data.processorName, data.processorAddress)
            .send({
                from: globCoinbase,
                to: contractRef.address
            })
            .on('transactionHash', function(hash) {
                $.magnificPopup.instance.close()
                handleTransactionResponse(hash);
            })
            .on('receipt', function(receipt) {
                receiptMessage = "Processing Updated Succussfully";
                handleTransactionReceipt(receipt, receiptMessage)
            })
            .on('error', function(error) {
                handleGenericError(error.message);
                return;
            });
    }

    function getCultivationEvents(contractRef) {
        contractRef.getPastEvents('PerformCultivation', {
            fromBlock: 0
        }).then(function(events) {
            $("#totalBatch").html(events.length);
            counterInit();

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
                    $("#userCultivationTable").find("tbody").html(table);

                    reInitPopupForm();
                }
            }, 1000);



            // $("#transactions tbody").html(buildTransactionData(events));
        }).catch(error => {
            console.log(error)
        });
    }

    function buildCultivationTable(finalEvents) {
        $.magnificPopup.instance.popupsCache = {};

        var table = "";

        for (var tmpDataIndex in finalEvents) {
            var elem = finalEvents[tmpDataIndex];
            var batchNo = elem.batchNo;
            var transactionHash = elem.transactionHash;
            var tr = "";

            if (elem.status == "FARM_INSPECTION") {
                tr = `<tr>
                    <td>` + batchNo + `</td>
                  `;

                if (globCurrentUser.role == "FARM_INSPECTION") {
                    tr += `<td>
                          <span class="label label-inverse font-weight-100">
                          <a class="popup-with-form" href="#farmInspectionForm" onclick="editActivity('` + batchNo + `')">
                            <span class="label label-inverse font-weight-100">Update</span>
                          </a>
                      </td>`;
                } else {
                    tr += `<td><span class="label label-warning font-weight-100">Processing</span> </td>`;
                }


                tr += `<td><span class="label label-danger font-weight-100">Not Available</span> </td>
              <td><span class="label label-danger font-weight-100">Not Available</span> </td>
              <td><span class="label label-danger font-weight-100">Not Available</span> </td>
              <td><span class="label label-danger font-weight-100">Not Available</span> </td>
              <td><a href="view-batch.php?batchNo=` + batchNo + `&txn=` + transactionHash + `" target="_blank" class="text-inverse p-r-10" data-toggle="tooltip" title="View"><i class="ti-eye"></i></a> </td>
          </tr>`;

            } else if (elem.status == "HARVESTER") {
                tr = `<tr>
                    <td>` + batchNo + `</td>
                    <td><span class="label label-success font-weight-100">Completed</span></td>
                    `;
                if (globCurrentUser.role == "HARVESTER") {
                    tr += `<td>
                              <span class="label label-inverse font-weight-100">
                              <a class="popup-with-form" href="#harvesterForm" onclick="editActivity('` + batchNo + `')">
                                <span class="label label-inverse font-weight-100">Update</span>
                              </a>
                          </td>`;
                } else {
                    tr += `<td><span class="label label-warning font-weight-100">Processing</span> </td>`;
                }

                tr += `
                <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                <td><a href="view-batch.php?batchNo=` + batchNo + `&txn=` + transactionHash + `" target="_blank" class="text-inverse p-r-10" data-toggle="tooltip" title="View"><i class="ti-eye"></i></a> </td>
            </tr>`;

            } else if (elem.status == "EXPORTER") {
                tr = `<tr>
                    <td>` + batchNo + `</td>
                    <td><span class="label label-success font-weight-100">Completed</span></td>
                    <td><span class="label label-success font-weight-100">Completed</span> </td>
                  `;

                if (globCurrentUser.role == "EXPORTER") {
                    tr += `<td>
                              <span class="label label-inverse font-weight-100">
                              <a class="popup-with-form" href="#exporterForm" onclick="editActivity('` + batchNo + `')">
                                <span class="label label-inverse font-weight-100">Update</span>
                              </a>
                          </td>`;
                } else {
                    tr += `<td><span class="label label-warning font-weight-100">Processing</span> </td>`;
                }

                tr += `  
                    <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                    <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                    <td><a href="view-batch.php?batchNo=` + batchNo + `&txn=` + transactionHash + `" target="_blank" class="text-inverse p-r-10" data-toggle="tooltip" title="View"><i class="ti-eye"></i></a> </td>
                </tr>`;
            } else if (elem.status == "IMPORTER") {
                tr = `<tr>
                    <td>` + batchNo + `</td>
                    <td><span class="label label-success font-weight-100">Completed</span></td>
                    <td><span class="label label-success font-weight-100">Completed</span> </td>
                    <td><span class="label label-success font-weight-100">Completed</span> </td>
                  `;

                if (globCurrentUser.role == "IMPORTER") {
                    tr += `<td>
                              <span class="label label-inverse font-weight-100">
                              <a class="popup-with-form" href="#importerForm" onclick="editActivity('` + batchNo + `')">
                                <span class="label label-inverse font-weight-100">Update</span>
                              </a>
                          </td>`;
                } else {
                    tr += `<td><span class="label label-warning font-weight-100">Processing</span> </td>`;
                }

                tr += ` <td><span class="label label-danger font-weight-100">Not Available</span> </td>
                    <td><a href="view-batch.php?batchNo=` + batchNo + `&txn=` + transactionHash + `" target="_blank" class="text-inverse p-r-10" data-toggle="tooltip" title="View"><i class="ti-eye"></i></a> </td>
                </tr>`;
            } else if (elem.status == "PROCESSOR") {
                tr = `<tr>
                    <td>` + batchNo + `</td>
                    <td><span class="label label-success font-weight-100">Completed</span></td>
                    <td><span class="label label-success font-weight-100">Completed</span> </td>
                    <td><span class="label label-success font-weight-100">Completed</span> </td>
                    <td><span class="label label-success font-weight-100">Completed</span> </td>
                  `;

                if (globCurrentUser.role == "PROCESSOR") {
                    tr += `<td>
                              <span class="label label-inverse font-weight-100">
                              <a class="popup-with-form" href="#processingForm" onclick="editActivity('` + batchNo + `')">
                                <span class="label label-inverse font-weight-150">Update</span>
                              </a>
                          </td>`;
                } else {
                    tr += `<td><span class="label label-warning font-weight-100">Processing</span> </td>`;
                }
                tr += `    
                    <td><a href="view-batch.php?batchNo=` + batchNo + `&txn=` + transactionHash + `" target="_blank" class="text-inverse p-r-10" data-toggle="tooltip" title="View"><i class="ti-eye"></i></a> </td>
                </tr>`;
            } else if (elem.status == "DONE") {
                tr = `<tr>
                    <td>` + batchNo + `</td>
                    <td><span class="label label-success font-weight-100">Completed</span></td>
                    <td><span class="label label-success font-weight-100">Completed</span> </td>
                    <td><span class="label label-success font-weight-100">Completed</span> </td>
                    <td><span class="label label-success font-weight-100">Completed</span> </td>
                    <td><span class="label label-success font-weight-100">Completed</span> </td>
                  `;
                tr += `    
                    <td><a href="view-batch.php?batchNo=` + batchNo + `&txn=` + transactionHash + `" target="_blank" class="text-inverse p-r-10" data-toggle="tooltip" title="View"><i class="ti-eye"></i></a> </td>
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

    function reInitPopupForm() {
        $('.popup-with-form').magnificPopup({
            type: 'inline',
            preloader: true,
            key: 'popup-with-form',
            // When elemened is focused, some mobile browsers in some cases zoom in
            // It looks not nice, so we disable it:
            callbacks: {
                open: function() {
                    stopLoader();
                }
            }
        });
    }
</script>

<div class="container-fluid">
    <div class="row bg-title">
        <!-- <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Dashboard</h4>
        </div> -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info" id="divOngoingTransaction" style="display: none">Ongoing Transaction: <span id="linkOngoingTransaction">None</span> </div>
        </div>
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="white-box">
                <div class="user-bg"> <img width="100%" alt="user" src="plugins/images/heading-bg/slide3.jpg">
                    <div class="overlay-box">
                        <div class="user-content">
                            <a href="javascript:void(0)"><img src="plugins/images/users/genu.jpg" id="userImage" class="thumb-lg img-circle" alt="img"></a>
                            <h4 class="text-white" id="userName">--</h4>
                            <h5 class="text-white" id="currentUserAddress">--</h5>
                        </div>
                    </div>
                </div>

                <div class="user-btm-box">
                    <div class="col-md-4 col-sm-4 text-center">
                        <p class="text-purple"><i class="fa fa-mobile"></i> Contact No</p>
                        <h2 id="userContact">--</h2>
                    </div>

                    <div class="col-md-4 col-sm-4 text-center">
                        <p class="text-blue"><i class="fa fa-user"></i> Role</p>
                        <h2 id="userRole">--</h2>
                    </div>
                    <div class="col-md-4 col-sm-4 text-center">
                        <p class="text-danger"><i class="fa fa-gears"></i> Settings</p>
                        <a class="btn btn-info m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light" id="editUser" href="javascript:void(0);">Edit</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--row -->
    <!-- /.row -->


    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Batches Overview</h3>
                <div class="table-responsive">
                    <table class="table product-overview" id="userCultivationTable">
                        <thead>
                            <tr>
                                <th>Batch ID</th>
                                <th>Farm Inspector</th>
                                <th>Harvester</th>
                                <th>Exporter</th>
                                <th>Importer</th>
                                <th>Processor</th>
                                <th>View</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" align="center">No Data Available</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Update User Form -->
                    <div id="userFormModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; padding-top: 170px;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h2 class="modal-title" id="userModelTitle">Update Profile</h2>
                                </div>

                                <div class="modal-body">
                                    <form id="updateUserForm" onsubmit="return false;">
                                        <fieldset style="border:0;">
                                            <div class="form-group">
                                                <label class="control-label" for="fullname">Full Name <i class="red">*</i></label>
                                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Name" data-parsley-required="true">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="contactNumber">Contact No<i class="red">*</i></label>
                                                <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="Contact No." data-parsley-required="true" data-parsley-type="digits" data-parsley-length="[10, 15]" maxlength="15">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="role">Role </label>
                                                <select class="form-control" id="role" disabled="true" name="role">
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
                                    <button type="button" class="btn btn-primary" id="userFormBtn">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Farm Inspection Form -->
                    <form id="farmInspectionForm" class="mfp-hide white-popup-block">
                        <h1>Farm Inspection</h1><br>
                        <fieldset style="border:0;">
                            <!-- <div class="form-group">
                                        <label class="control-label" for="InspectorId">Inspector ID Number</label>
                                        <input type="text" class="form-control" id="InspectorId" name="inspectorId" placeholder="inspector id number" data-parsley-required="true">
                                    </div>   -->
                            <div class="form-group">
                                <label class="control-label" for="typeOfSeed">Type of Seed</label>
                                <input type="text" class="form-control" id="typeOfSeed" name="typeOfSeed" placeholder="type of seed" data-parsley-required="true">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="coffeeFamily">Tea Family</label>
                                <input type="text" class="form-control" id="coffeeFamily" name="coffeeFamily" placeholder="tea family" data-parsley-required="true">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="fertilizer">Fertilizer Used</label>
                                <input type="text" class="form-control" id="fertilizerUsed" name="fertilizer" placeholder="fertilizer used" data-parsley-required="true">
                            </div>
                            <div class="form-group float-right">
                                <button type="reset" class="btn btn-default waves-effect">Reset</button>
                                <button type="button" id="updateFarmInspection" class="btn btn-primary">Submit</button>
                            </div>
                        </fieldset>
                    </form>

                    <!-- Harvesting Form -->
                    <form id="harvesterForm" class="mfp-hide white-popup-block ">
                        <h1>Harvesting</h1><br>
                        <fieldset style="border:0;">

                            <div class="form-group">
                                <label class="control-label" for="cropVariety">Tea Variety</label>
                                <input type="text" class="form-control" id="cropVariety" name="cropVariety" placeholder="tea variety" data-parsley-required="true">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="temperatureUsed">Temperature (in Fahrenheit)</label>
                                <input type="text" class="form-control" id="temperatureUsed" name="temperatureUsed" placeholder="temperature" data-parsley-required="true">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="humidity">Humidity</label>
                                <input type="text" class="form-control" id="humidity" name="humidity" placeholder="humidity" data-parsley-required="true">
                            </div>
                            <div class="form-group float-right">
                                <button type="reset" class="btn btn-default waves-effect">Reset</button>
                                <button type="button" id="updateHarvest" class="btn btn-primary">Submit</button>
                            </div>
                        </fieldset>
                    </form>

                    <!-- Exporter Form -->
                    <form id="exporterForm" class="mfp-hide white-popup-block">
                        <h1>Exporting</h1><br>
                        <fieldset style="border:0;">

                            <div class="form-group">
                                <label class="control-label" for="quantity">Quantity (in Kg)</label>
                                <input type="number" min="1" class="form-control" id="quantity" name="quantity" placeholder="Quantity" data-parsley-required="true">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="destinationAddress">Destination Address</label>
                                <input type="text" class="form-control" id="destinationAddress" name="destinationAddress" placeholder="Destination Address" data-parsley-required="true">
                            </div>


                            <div class="form-group">
                                <label class="control-label" for="shipName">Ship Name</label>
                                <input type="text" class="form-control" id="shipName" name="shipName" placeholder="Ship Name" data-parsley-required="true">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="shipNo">Ship No</label>
                                <input type="text" class="form-control" id="shipNo" name="shipNo" placeholder="Ship No" data-parsley-required="true">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="estimateDateTime">Estimate Datetime</label>
                                <input type="text" class="form-control datepicker-master" id="estimateDateTime" name="estimateDateTime" placeholder="Estimate Datetime" data-parsley-required="true">
                            </div>



                            <div class="form-group">
                                <label class="control-label" for="exporterId">Exporter ID</label>
                                <input type="number" class="form-control" id="exporterId" name="exporterId" placeholder="Exporter ID" data-parsley-required="true">
                            </div>


                            <div class="form-group float-right">
                                <button type="reset" class="btn btn-default waves-effect">Reset</button>
                                <button type="button" id="updateExport" class="btn btn-primary">Submit</button>
                            </div>
                        </fieldset>
                    </form>

                    <!-- Importer Form -->
                    <form id="importerForm" class="mfp-hide white-popup-block">
                        <h1>Importing</h1><br>
                        <fieldset style="border:0;">

                            <div class="form-group">
                                <label class="control-label" for="quantity">Quantity</label>
                                <input type="number" min="1" class="form-control" id="quantity" name="quantity" placeholder="Quantity" data-parsley-required="true">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="shipName">Ship Name</label>
                                <input type="text" class="form-control" id="shipName" name="shipName" placeholder="Ship Name" data-parsley-required="true">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="shipNo">Ship No</label>
                                <input type="text" class="form-control" id="shipNo" name="shipNo" placeholder="Ship No" data-parsley-required="true">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="transportInfo">Transport Info</label>
                                <input type="text" class="form-control" id="transportInfo" name="transportInfo" placeholder="Transport Info" data-parsley-required="true">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="warehouseName">Warehouse Name</label>
                                <input type="text" class="form-control" id="warehouseName" name="warehouseName" placeholder="Warehouse Name" data-parsley-required="true">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="warehouseAddress">Warehouse Address</label>
                                <input type="text" class="form-control" id="warehouseAddress" name="warehouseAddress" placeholder="Warehouse Address" data-parsley-required="true">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="importerId">Importer Id</label>
                                <input type="number" min="1" class="form-control" id="importerId" name="importerId" placeholder="Importer Id" data-parsley-required="true">
                            </div>

                            <div class="form-group float-right">
                                <button type="reset" class="btn btn-default waves-effect">Reset</button>
                                <button type="button" id="updateImport" class="btn btn-primary">Submit</button>
                            </div>
                        </fieldset>
                    </form>

                    <!-- Processor Form -->
                    <form id="processingForm" class="mfp-hide white-popup-block">
                        <h1>Processing</h1><br>
                        <fieldset style="border:0;">
                            <div class="form-group">
                                <label class="control-label" for="quantity">Quantity (in Kg)</label>
                                <input type="number" min="1" class="form-control" id="quantity" name="quantity" placeholder="Quantity" data-parsley-required="true">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="processingTemperature">Temperature (in Fahrenheit)</label>
                                <input type="text" class="form-control" id="processingTemperature" name="temperature" placeholder="Temperature" data-parsley-required="true">
                            </div>
                            <div class="form-group">
                                <!-- <label class="control-label" for="rostingDuration">Time for Roasting (in Seconds)</label> -->
                                <input type="hidden" min="1" class="form-control" id="rostingDuration" name="rostingDuration" value="6418" placeholder="Time for roasting" data-parsley-required="true">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="internalBatchNo">Internal Batch no</label>
                                <input type="text" class="form-control" id="internalBatchNo" name="internalBatchNo" placeholder="Internal Batch no" data-parsley-required="true">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="packageDateTime">Packaging Date & Time</label>
                                <input type="text" class="form-control datepicker-master" id="packageDateTime" name="packageDateTime" placeholder="Packaging Date" data-parsley-required="true">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="processorName">Processor Name</label>
                                <input type="text" class="form-control" id="processorName" name="processorName" placeholder="Processor Name" data-parsley-required="true">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="processorAddress">Processor Address</label>
                                <input type="text" class="form-control" id="processorAddress" name="processorAddress" placeholder="Processor Address" data-parsley-required="true">
                            </div>
                            <div class="form-group float-right">
                                <button type="reset" class="btn btn-default waves-effect">Reset</button>
                                <button type="button" id="updateProcessor" class="btn btn-primary">Submit</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->



<?php include('templates/_footer.php'); ?>