@extends('master')

@section('mainContent')
    <div class="col-md-12">

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3>Product List </h3>
                @if(!is_null($category_name))
                    <label>{{$category_name}}</label>
                @endif
                {{--<a class="btn btn-primary" href="{{url('publishFlash')}}">Publish</a>--}}
                {{--<a class="btn btn-danger" href="{{url('offlineFlash')}}">Offline</a>--}}
            </div>
            <div class="panel-body">

                <div class="row" ng-app="myApp" ng-controller="autoComplete">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="category" class="form-control" ng-model="categoryFilter" placeholder="category name">
                            <ul class="list-group" ng-if="categoryFilter" >
                                <a ng-repeat="x in categorys | filter : categoryFilter" href="?id=@{{ x.id }}" class="list-group-item @{{ x.status }}">@{{x.name}}</a>



                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <a href="{{url('/batchEditPrice',[$category_id])}}" class="btn btn-default text-capitalize">Batch edit price</a>
                        <a href="{{url('/addProductinLabel',[$category_id])}}" class="btn btn-default text-capitalize">Print label</a>
                        <button class="btn btn-danger text-capitalize" onclick="cleanUnspecial()">Clean unspecial product from category</button>
                        <script>
                            function cleanUnspecial(){
                                var url = "{{url('/cleanOnSaleCategory')}}?id={{$category_id}}";
                                var r = confirm("Are you sure clean the unspecial product!");
                                if (r == true) {
                                    window.location.href=url;
                                }
                            }
                        </script>
                        {!! Form::open(['url'=>'dryCategory2Other']) !!}
                            {!! Form::input('hidden','category_id',$category_id) !!}
                            <div class="input-group">
                                {!! Form::text('otherCategory',null,['class'=>'form-control']) !!}
                                <span class="input-group-btn">
                                    {!! Form::submit('Copy special to!',['class'=>'btn btn-secondary']) !!}
                                </span>
                            </div>

                        {!! Form::close() !!}
                        <button type="button" ng-click="updateMpn()" class="btn btn-default text-capitalize sr-only" id="btnMpn">Check MPN</button>

                    </div>

                    <div class="col-sm-12">
                        <table class="table table-striped">
                            <thead>
                            <tr >
                                <th class="col-md-1"></th>
                                <th class="col-md-1">Model</th>
                                <th class="col-md-5">title</th>
                                <th class="col-md-1">Price</th>
                                <th class="col-md-1">Special</th>
                                <th class="col-md-2">MPN</th>

                                <th class="col-md-1">Action</th>
                            </tr>
                            </thead>
                            @if(!is_null($result))
                            @foreach($result as $key=>$single)
                                <tr class="{{$single['status']}}">
                                    <td>{{$key+1}}</td>
                                    <td>{{$single['product']->model}}</td>
                                    <td>{{isset($single['product_detail']->name)?$single['product_detail']->name:'error'}}</td>
                                    <td>{{round($single['product']->price*1.15,2)}}</td>
                                    <td>{{round($single['special'],2)}}</td>
                                    <td id="mpn_{{$single['product']->product_id}}">{{$single['product']->mpn}}</td>
                                    <td><a href="{{url('/deleteProductFromCategory',[$category_id,$single['product']->product_id])}}" class="btn btn-danger">Del</a></td>
                                </tr>
                            @endforeach
                            @endif
                            {!! Form::open(['url'=>'saveProduct2Category']) !!}
                            <tr>
                                {{Form::input('hidden','category_id',$category_id)}}
                                <td id="models"><input type="text" name="modelnum" class="form-control" placeholder="Model" required>
                                </td>
                                <td></td>
                                <td><input type="submit" value="submit" class="btn btn-primary"></td>
                            </tr>
                            {!! Form::close() !!}

                        </table>

                    </div>


                </div>

            </div>
        </div>

    </div>
    <script>



        var myapp = angular.module('myApp', []);
        myapp.controller('autoComplete',function($scope,$http){
           $scope.categorys = {!! $categorys !!};
            @if(!is_null($result))
            $('#btnMpn').removeClass('sr-only');
           var todoProductList = [

               @foreach($result as $single)
               {{$single['product']->product_id.','}}
               @endforeach

           ];
           $scope.updateMpn = function(){
//               $('#btnMpn').button('loading');
               var url = '';
               $.each(todoProductList, function( key,value ) {
                   url='{{env('CRAWLER_URL')}}/api/products/mpn/'+value;
                   $http.jsonp(url).success(

                       function(data, status, header, config){
                           $('#mpn_'+value).addClass(data);
                       }
//                       function(data){
//                           $('#mpn_'+value).addClass('text-success');                       }
                   );

               });
//               location.reload();
           }
            @endif

        });
    </script>

@endsection