@extends('layouts.app')

@section('content')
    <div class="container w-50">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>Customer Create</div>
            </div>
            <div class="card card-body border-0 shadow table-wrapper table-responsive">
                <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="customerName">Customer Name</label>
                        <input type="text" class="form-control" name="customerName" placeholder="Enter customer name"
                            value="{{ old('customerName') }}" maxlength="41">
                        @error('customerName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="pipelineAccountNum">Account Number</label>
                        <input type="number" class="form-control" name="pipelineAccountNum"
                            placeholder="Enter account number" value="{{ old('pipelineAccountNum') }}">
                        @error('pipelineAccountNum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" name="city" placeholder="Enter city"
                            value="{{ old('city') }}">
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="countryId">Country ID</label>
                        <input type="number" class="form-control" name="countryId" placeholder="Enter country ID"
                            value="{{ old('countryId') }}" min="0">
                        @error('countryId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="locationGroupId">Location Group ID</label>
                        <input type="number" class="form-control" name="locationGroupId"
                            placeholder="Enter location group ID" value="{{ old('locationGroupId') }}" min="0">
                        @error('locationGroupId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="addressName">Address Name</label>
                        <input type="text" class="form-control" name="addressName" placeholder="Enter address name"
                            value="{{ old('addressName') }}">
                        @error('addressName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="stateId">State ID</label>
                        <input type="number" class="form-control" name="stateId" placeholder="Enter state ID"
                            value="{{ old('stateId') }}" min="0">
                        @error('stateId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" placeholder="Enter address"
                            value="{{ old('address') }}" required>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="typeID">Type ID</label>
                        <input type="number" class="form-control" name="typeID" placeholder="Enter type ID"
                            value="{{ old('typeID') }}" min="0">
                        @error('typeID')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="zip">ZIP Code</label>
                        <input type="text" class="form-control" name="zip" placeholder="Enter ZIP code"
                            value="{{ old('zip') }}">
                        @error('zip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="accountTypeId">Account Type ID</label>
                        <input type="number" class="form-control" name="accountTypeId" placeholder="Enter account type ID"
                            value="{{ old('accountTypeId') }}">
                        @error('accountTypeId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="activeFlag">Active Flag</label>
                        <input type="checkbox" class="form-control" name="activeFlag" value="1"
                            {{ old('activeFlag') ? 'checked' : '' }}>
                        @error('activeFlag')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="creditLimit">Credit Limit</label>
                        <input type="number" class="form-control" name="creditLimit" step="0.01"
                            placeholder="Enter credit limit" value="{{ old('creditLimit') }}">
                        @error('creditLimit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="currencyId">Currency ID</label>
                        <input type="number" class="form-control" name="currencyId" placeholder="Enter currency ID"
                            value="{{ old('currencyId') }}">
                        @error('currencyId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="currencyRate">Currency Rate</label>
                        <input type="number" class="form-control" name="currencyRate" step="0.01"
                            placeholder="Enter currency rate" value="{{ old('currencyRate') }}">
                        @error('currencyRate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="dateCreated">Date Created</label>
                        <input type="date" class="form-control" name="dateCreated" placeholder="Enter date created"
                            value="{{ old('dateCreated') }}">
                        @error('dateCreated')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="dateLastModified">Date Last Modified</label>
                        <input type="date" class="form-control" name="dateLastModified"
                            placeholder="Enter date last modified" value="{{ old('dateLastModified') }}">
                        @error('dateLastModified')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="defaultCarrierId">Default Carrier ID</label>
                        <input type="number" class="form-control" name="defaultCarrierId"
                            placeholder="Enter default carrier ID" value="{{ old('defaultCarrierId') }}">
                        @error('defaultCarrierId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="defaultPaymentTermsId">Default Payment Terms ID</label>
                        <input type="number" class="form-control" name="defaultPaymentTermsId"
                            placeholder="Enter default payment terms ID" value="{{ old('defaultPaymentTermsId') }}">
                        @error('defaultPaymentTermsId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="defaultSalesmanId">Default Salesman ID</label>
                        <input type="number" class="form-control" name="defaultSalesmanId"
                            placeholder="Enter default salesman ID" value="{{ old('defaultSalesmanId') }}">
                        @error('defaultSalesmanId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="defaultShipTermsId">Default Ship Terms ID</label>
                        <input type="number" class="form-control" name="defaultShipTermsId"
                            placeholder="Enter default ship terms ID" value="{{ old('defaultShipTermsId') }}">
                        @error('defaultShipTermsId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jobDepth">Job Depth</label>
                        <input type="number" class="form-control" name="jobDepth" placeholder="Enter job depth"
                            value="{{ old('jobDepth') }}">
                        @error('jobDepth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="lastChangedUser">Last Changed User</label>
                        <input type="text" class="form-control" name="lastChangedUser"
                            placeholder="Enter last changed user" value="{{ old('lastChangedUser') }}" maxlength="15">
                        @error('lastChangedUser')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="note">Note</label>
                        <input type="text" class="form-control" name="note" placeholder="Enter note"
                            value="{{ old('note') }}" maxlength="90">
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="number">Number</label>
                        <input type="text" class="form-control" name="number" placeholder="Enter number"
                            value="{{ old('number') }}" maxlength="30">
                        @error('number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parentId">Parent ID</label>
                        <input type="number" class="form-control" name="parentId" placeholder="Enter parent ID"
                            value="{{ old('parentId') }}">
                        @error('parentId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="form-group">
                        <label for="qbClassId">QB Class ID</label>
                        <input type="number" class="form-control" name="qbClassId" placeholder="Enter QB class ID"
                            value="{{ old('qbClassId') }}">
                        @error('qbClassId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="statusId">Status ID</label>
                        <input type="number" class="form-control" name="statusId" placeholder="Enter status ID"
                            value="{{ old('statusId') }}">
                        @error('statusId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="sysUserId">Sys User ID</label>
                        <input type="number" class="form-control" name="sysUserId" placeholder="Enter sys user ID"
                            value="{{ old('sysUserId') }}">
                        @error('sysUserId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="taxExempt">Tax Exempt</label>
                        <input type="checkbox" class="form-control" name="taxExempt" value="1"
                            {{ old('taxExempt') ? 'checked' : '' }}>
                        @error('taxExempt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="taxExemptNumber">Tax Exempt Number</label>
                        <input type="text" class="form-control" name="taxExemptNumber"
                            placeholder="Enter tax exempt number" value="{{ old('taxExemptNumber') }}" maxlength="30">
                        @error('taxExemptNumber')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="taxRateId">Tax Rate ID</label>
                        <input type="number" class="form-control" name="taxRateId" placeholder="Enter tax rate ID"
                            value="{{ old('taxRateId') }}">
                        @error('taxRateId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="toBeEmailed">To Be Emailed</label>
                        <input type="checkbox" class="form-control" name="toBeEmailed" value="1"
                            {{ old('toBeEmailed') ? 'checked' : '' }}>
                        @error('toBeEmailed')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="toBePrinted">To Be Printed</label>
                        <input type="checkbox" class="form-control" name="toBePrinted" value="1"
                            {{ old('toBePrinted') ? 'checked' : '' }}>
                        @error('toBePrinted')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="url">URL</label>
                        <input type="url" class="form-control" name="url" placeholder="Enter URL"
                            value="{{ old('url') }}" maxlength="30">
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="issuableStatusId">Issuable Status ID</label>
                        <input type="number" class="form-control" name="issuableStatusId"
                            placeholder="Enter issuable status ID" value="{{ old('issuableStatusId') }}">
                        @error('issuableStatusId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="carrierServiceId">Carrier Service ID</label>
                        <input type="number" class="form-control" name="carrierServiceId"
                            placeholder="Enter carrier service ID" value="{{ old('carrierServiceId') }}">
                        @error('carrierServiceId')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    3<button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
@endsection
