@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>List of Forms</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="10%">No</th>
                            <th>Form Name</th>
                            <th width="35%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($forms as $key=>$form)
                            <tr>
                                <td>{{$form['id']}}</td>
                                <td>Form {{$key + 1}}</td>
                                <td>
                                    <a href="#" class="btn btn-info text-white">Edit</a>
                                    <a href="#" class="btn btn-danger text-white">Delete</a>
                                    <a href="/generate_pdf/{{$form['id']}}" class="btn btn-primary text-white" target="_blank">Download</a>
                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#form-preview-{{$key+1}}">
                                        Preview
                                    </button>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="form-preview-{{$key+1}}" tabindex="-1" role="dialog" aria-labelledby="form-preview-{{$key+1}}Title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="form-preview-{{$key+1}}Title">Modal title {{$key+1}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach( $form['form_data'] as $item )
                                                @if( $item->type == 'upload-field' )
                                                    <img src="{{ asset('/storage/images') }}/{{$item->value}}" class="img-fluid mb-2 mt-2" alt="">
                                                @endif
                                                @if( $item->type == 'label-field' )
                                                    <p class="h4">{{$item->value}}</p>
                                                @endif
                                                @if( $item->type == 'text-field' )
                                                    <p>{{$item->value}}</p>
                                                @endif
                                                @if( $item->type == 'textarea-field' )
                                                    <p>{{$item->value}}</p>
                                                @endif
                                                
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <a href="/generate_pdf/{{$form['id']}}" class="btn btn-primary text-white">Save as PDF</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    
@endsection