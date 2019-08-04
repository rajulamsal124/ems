<div class="modal fade" id="addStudent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Manage Program</h3>
            </div>
            <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Update Student
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            <div role="tabpanel">
                <ul class="nav nav-tabs" role="tablist" id="tabList">
                    <li role="presentation" class="active">
                        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a>
                    </li>

                    <li role="presentation">
                        <a href="#details" aria-controls="details" role="tab" data-toggle="tab">Personal Details</a>
                    </li>

                    <li role="presentation">
                        <a href="#education" aria-controls="education" role="tab" data-toggle="tab">Education</a>
                    </li>

                    <li role="presentation">
                        <a href="#cdetails" aria-controls="cdetails" role="tab" data-toggle="tab">Contact Details</a>
                    </li>
                    <li role="presentation">
                        <a href="#doc" aria-controls="doc" role="tab" data-toggle="tab">Documentation</a>
                    </li>
                </ul>

                <div class="tab-content">
                <br>
                    <div role="tabpanel" class=" tab-pane active" id="home">
                        <form role="form">
                            <div class="form-group col-md-6">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mname">Middle Name</label>
                                <input type="text" class="form-control" name="mname" id="mname" placeholder="Middle Name" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-12 text-right">
                                    <a href="#" class="btn btn-primary next">Next</a>
                            </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="details">
                            <div class="form-group col-md-6">
                                <label for="program">Program</label>
                                <select class="form-control" id="program" name="program">
                                    <option value="1">BBA</option>
                                    <option value="2">BCA</option>
                                    <option value="3">BPH</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="doa">Date of Application</label>
                                <input type="date" class="form-control" name="doa" id="doa" placeholder="Date of Application" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dob">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" id="dob" placeholder="Date of Birth" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nationality">Nationality</label>
                                <input type="text" class="form-control" name="nationality" id="nationality" placeholder="Nationality" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fatherName">Father's Name</label>
                                <input type="text" class="form-control" name="fatherName" id="fatherName" placeholder="Father's Name" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-12 text-right">
                                    <a href="#" class="btn btn-primary previous">Previous</a>
                                    <a href="#" class="btn btn-primary next">Next</a>
                            </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="education">
                        <div class="form-group col-md-12 text-right">
                            <button type="button" id="addEducation" class="btn btn-success">+</button>
                            <input type="hidden" data-id="0" id="counter" />
                        </div>
                        <div id="nestedForm">
                        </div>
                            <div class="form-group col-md-12 text-right">
                                    <a href="#" class="btn btn-primary previous">Previous</a>
                                    <a href="#" class="btn btn-primary next">Next</a>
                            </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="cdetails">
                            <div class="form-group col-md-6">
                                <label for="municipality">Municipality</label>
                                <input type="text" class="form-control" name="municipality" id="municipality" placeholder="Municipality" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="wardNo">Ward. NO</label>
                                <input type="number" class="form-control" name="wardNo" id="wardNo" placeholder="Ward. NO" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="area">Area</label>
                                <input type="text" class="form-control" name="area" id="area" placeholder="Area" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="district">District</label>
                                <input type="text" class="form-control" name="district" id="district" placeholder="District" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="zone">Zone</label>
                                <input type="text" class="form-control" name="zone" id="zone" placeholder="Zone" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobileNo">Mobile No</label>
                                <input type="text" class="form-control" name="mobileNo" id="mobileNo" placeholder="Mobile No" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telephoneNo">Telephone No</label>
                                <input type="text" class="form-control" name="telephoneNo" id="telephoneNo" placeholder="Telephone No" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="blockNo">Block No</label>
                                <input type="text" class="form-control" name="blockNo" id="blockNo" placeholder="Block No" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="guardianName">Guardian Name</label>
                                <input type="text" class="form-control" name="guardianName" id="guardianName" placeholder="Guardian Name" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="guardianRelation">Guardian Relationship</label>
                                <input type="text" class="form-control" name="guardianRelation" id="guardianRelation" placeholder="Guardian Relationship" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="guardianContact">Guardian Contact</label>
                                <input type="text" class="form-control" name="guardianContact" id="guardianContact" placeholder="Gurdian Contact" />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-12 text-right">
                                    <a href="#" class="btn btn-primary previous">Previous</a>
                                    <a href="#" class="btn btn-primary next">Next</a>
                            </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="doc">
                            <div class="form-group col-md-6">
                                <label for="formNo">Form No.</label>
                                <input type="number" class="form-control" name="formNo" id="formNo" placeholder="Form No." />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="entranceNo">Entrance NO.</label>
                                <input type="number" class="form-control" name="entranceNo" id="entranceNo" placeholder="Entrance NO." />
                                <span class="help-inline"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="has-success">
                                    <div class="checkbox">
                                        <label for="eligible">
                                        <input type="checkbox" id="eligible" name="eligible" value="1">
                                       Eligible 
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="has-success">
                                    <div class="checkbox">
                                        <label for="marksheet">
                                        <input type="checkbox" id="marksheet" name="marksheet" value="1">
                                       Mark Sheet 
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="has-success">
                                    <div class="checkbox">
                                        <label for="characterCertificate">
                                        <input type="checkbox" id="characterCertificate" name="characterCertificate" value="1">
                                       Character Certificate 
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="has-success">
                                    <div class="checkbox">
                                        <label for="citizenship">
                                        <input type="checkbox" id="citizenship" name="citizenship" value="1">
                                       CitizenShip 
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="has-success">
                                    <div class="checkbox">
                                        <label for="photo">
                                        <input type="checkbox" id="photo" name="photo" value="1">
                                       Photo 
                                        </label>
                                    </div>
                                    </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="has-success">
                                    <div class="checkbox">
                                        <label for="minimumPercent">
                                        <input type="checkbox" id="minimumPercent" name="minimumPercent" value="1">
                                        Minimum Percent 
                                        </label>
                                    </div>
                                    </div>
                            </div>
                            <div class="form-group col-md-12 text-right">
                                    <a href="#" class="btn btn-primary previous">Previous</a>
                                    <a href="#" class="btn btn-warning">Submit</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="submit" class="btn btn-primary" id="saveBtn">Add</button>
                <button type="reset" class="btn btn-warning">Reset</button>
                <button class="btn btn-default" data-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>