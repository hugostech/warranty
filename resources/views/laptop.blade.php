@extends('master')

@section('mainContent')
    {!! Form::open(['url'=>'laptop_attribute']) !!}
    <input type="hidden" name="product_id" value="{{$id}}">
    <div class="col-md-6 col-md-offset-3">
        <table class="table table-strip">

            <tr>

                <td>
                    <div class="form-group has-feedback">
                        <label class="control-label" for="inputSuccess2">CPU Family</label>

                        {!! Form::select('30',$cpus,null,['class'=>'form-control','placeholder' => 'Pick a CPU...']) !!}

                        {{--<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>--}}
                        {{--<span id="inputSuccess2Status" class="sr-only">(success)</span>--}}
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                <div class="form-group has-feedback">
                    <label class="control-label" for="inputSuccess2">RAM size</label>
                    {!! Form::input('number','31',null,['class'=>'form-control']) !!}


                    {{--<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>--}}
                    {{--<span id="inputSuccess2Status" class="sr-only">(success)</span>--}}
                </div>
                </td>
            </tr>
            <tr>
                <td>
                <div class="form-group has-feedback">
                    <label class="control-label" for="inputSuccess2">Screen size</label>

                    {!! Form::input('number','32',null,['class'=>'form-control','placeholder' => 'Entry Screen size','step'=>'0.1']) !!}


                </div>
                </td>
            </tr>
            <tr>
                <td>
                <div class="form-group has-feedback">
                    <label class="control-label" for="inputSuccess2">HDD size</label>
                    {!! Form::input('number','33',null,['class'=>'form-control']) !!}


                </div>
                </td>
            </tr>
            <tr>
                <td>
                <div class="form-group has-feedback">
                    <label class="control-label" for="inputSuccess2">SSD size</label>
                    <input type="number" name="34" class="form-control">


                </div>
                </td>
            </tr>
            <tr>
                <td>
                <div class="form-group has-feedback">
                    <label class="control-label" for="inputSuccess2">Graphics card</label>

                    {!! Form::select('35',$graphics_card,null,['class'=>'form-control','placeholder' => 'Pick a graphic_card...']) !!}


                </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group has-feedback">
                        <label class="control-label" for="inputSuccess2">Screen Resolution</label>

                        {!! Form::select('36',$resolution,null,['class'=>'form-control','placeholder' => 'Pick a Resolution...']) !!}


                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    {!! Form::submit('Save') !!}
                </td>
            </tr>

        </table>
    </div>
{!! Form::close() !!}
@endsection