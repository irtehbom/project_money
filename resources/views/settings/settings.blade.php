@extends('layouts.app')
@section('content')


<div class="row">
    <div class="col-md-12 ">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Settings <small>store settings</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Settings
                    </li>
                </ol>
            </div>
        </div>

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Main Settings</a></li>
            <li><a data-toggle="tab" href="#amazon">Amazon ID's</a></li>
        </ul>

        <form method="POST" id="form-validate" name="form-validate" action="{{ url('settings/update_settings/') }}">

            {{ csrf_field() }}

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">

                    <h3>Settings</h3>
                    
                    Logo

                    <div class="spacer">
                    </div>
                    <div class="input-group image-preview">
                        
                        @if( isset($object->logo))
                        
                        <input type="text" class="form-control" name="logo" value="{{$object->logo}}">
                        
                        @else
                            
                        <input type="text" class="form-control" name="logo" value="">
                            
                        @endif
                        
                        <span class="input-group-btn">
                            <!-- image-preview-clear button -->
                            <!-- image-preview-input -->
                            <div class="btn btn-default image-preview-input" data-target="#my_modal" data-toggle="modal">
                                <span class="glyphicon glyphicon-folder-open"></span>
                                <span class="image-preview-input-title media_upload">Browse</span>
                            </div>
                        </span>
                    </div><!-- /input-group image-preview [TO HERE]--> 

                    <div class="spacer">
                    </div>

                    Select Amazon Store
                    <div class="spacer">

                        @if($object->storeLocale == 'US')
                        selected
                        @endif

                        <select class="selectpicker" name="amazonLocale" id="amazonLocale">
                            <option value="US">United States</option>
                            <option value="GB">United Kingdom</option>
                            <option value="CA">Canada</option>
                        </select>
                    </div>

                    Select Homepage
                    <div class="spacer">


                        <select class="selectpicker" name="homepage" id="homepage">

                            @foreach ($pages as $page)
                            @if ($object->homepage == $page->id)
                            <option selected value="{{$page->id}}">{{$page->title}}</option>
                            @else
                            <option value="{{$page->id}}">{{$page->title}}</option>
                            @endif
                            @endforeach

                        </select>
                    </div>
                </div>



                <div class='spacer'></div>
                <div id="amazon" class="tab-pane">

                    <h3>Amazon Country ID's</h3>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Country</th>
                                <th>Amazon ID's (comma seperated if multiple)</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <tr>
                                <td>United Kingdom</td>
                                @if( isset($object->location_ids->GB))
                                <td><input class="form-control" type='input' name='location_ids[GB]' value='{{$object->location_ids->GB}}'></td>
                                @else
                                <td><input class="form-control" type='input' name='location_ids[GB]' value=''></td>
                                @endif
                            </tr>

                            <tr>
                                <td>United States</td>
                                @if( isset($object->location_ids->US))
                                <td><input class="form-control" type='input' name='location_ids[US]' value='{{$object->location_ids->US}}'></td>
                                @else
                                <td><input class="form-control" type='input' name='location_ids[US]' value=''></td>
                                @endif
                            </tr>

                            <tr>
                                <td>Canada</td>
                                @if( isset($object->location_ids->CA))
                                <td><input class="form-control" type='input' name='location_ids[CA]' value='{{$object->location_ids->CA}}'></td>
                                @else
                                <td><input class="form-control" type='input' name='location_ids[CA]' value=''></td>
                                @endif
                            </tr>

                        </tbody>
                    </table>

                </div>

                <div class="spacer">
                </div>

                <button type="submit" class="btn btn-success btn-lg btn-block">Save all Settings</button>

                <div class="spacer">
                </div>
        </form>
    </div>
</div>


<div id="modal-large">
    <div class="modal fade" id="my_modal" tabindex="-1" role="dialog" aria-labelledby="my_modalLabel">
        <div class="modal-dialog" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">File Details</h4>
                </div>
                <div class="modal-body">
                    @include('partials/file_manager')
                </div>
                <div class="modal-footer" style="clear:both;">
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection