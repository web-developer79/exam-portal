<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@extends('layouts.app')

@section('content')
<div class="container" style="background-color:white" align="center">

    <img src="{{url('img/load_spinner.gif')}}" />
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="{{ $data['action'] }}" method="post" name="payuForm">
                        <input type="hidden" name="key" value="{{ $data['merchantkey'] }}" readonly />
                        <input type="hidden" name="hash" value="{{ $data['hash'] }}" readonly />
                        <input type="hidden" name="txnid" value="{{ $data['txnid'] }}" readonly />
                        {{ csrf_field() }}

                         <input type="hidden" name="amount" value="{{$data['amount']}}" readonly />
                          <input type="hidden" name="firstname" value="{{$data['firstname']}}" readonly />
                          <input type="hidden" name="email" value="{{$data['email']}}" readonly />
                          <input type="hidden" name="phone" value="{{$data['phone']}}" readonly/>
                          <textarea style="display:none;" name="productinfo">{{$data['productinfo']}}</textarea>
                          <input type="hidden" name="surl" value="{{$data['surl']}}" size="64" readonly />
                          <input type="hidden" name="furl" value="{{$data['furl']}}" size="64" readonly />
                          <input type="hidden" name="service_provider" value="payu_paisa" size="64" readonly/>
                          <input type="hidden" name="lastname" id="lastname" value="{{$data['lastname']}}" readonly/>
                          <input type="hidden" name="curl" value="{{$data['curl']}}" readonly/>
                          <input type="hidden" name="address1" value="{{$data['address1']}}" readonly/>
                          <input type="hidden" name="address2" value="" />
                          <input type="hidden" name="city" value="{{$data['city']}}" readonly/>
                          <input type="hidden" name="state" value="{{$data['state']}}" readonly/>
                          <input type="hidden" name="country" value="india" />
                          <input type="hidden" name="zipcode" value="{{isset($data['zipcode']) ? $data['zipcode'] : ''}}" readonly/>
                          <input type="hidden" name="udf1" value="{{isset($data['udf1']) ? $data['udf1'] : ''}}" readonly/>
                          <input type="hidden" name="udf2" value="{{isset($data['udf2']) ? $data['udf2'] : ''}}" readonly/>
                          <input type="hidden" name="udf3" value="{{isset($data['udf3']) ? $data['udf3'] : ''}}" />
                          <input type="hidden" name="udf4" value="{{isset($data['udf4']) ? $data['udf4'] : ''}}" />
                          <input type="hidden" name="udf5" value="{{isset($data['udf5']) ? $data['udf5'] : ''}}" />
                          <input type="hidden" name="pg" value="{{isset($data['pg']) ? $data['pg'] : ''}}" />

                        {{--<table>
                         <tr> <td><input type="hidden" name="amount" value="{{$data['amount']}}" readonly /></td>
                          <td><input type="hidden" name="firstname" value="{{$data['firstname']}}" readonly /></td>
                          <td><input type="hidden" name="email" value="{{$data['email']}}" readonly /></td>
                          <td><input type="hidden" name="phone" value="{{$data['phone']}}" readonly/></td>
                          <td colspan="3"><textarea style="display:none;" name="productinfo">{{$data['productinfo']}}</textarea></td>
                          <td colspan="3"><input type="hidden" name="surl" value="{{$data['surl']}}" size="64" readonly /></td>
                          <td colspan="3"><input type="hidden" name="furl" value="{{$data['furl']}}" size="64" readonly /></td>
                          <td colspan="3"><input type="hidden" name="service_provider" value="payu_paisa" size="64" readonly/></td>
                          <td><input type="hidden" name="lastname" id="lastname" value="{{$data['lastname']}}" readonly/></td>
                          <td><input type="hidden" name="curl" value="{{$data['curl']}}" readonly/></td>
                          <td><input type="hidden" name="address1" value="{{$data['address1']}}" readonly/></td>
                          <td><input type="hidden" name="address2" value="" /></td>
                          <td><input type="hidden" name="city" value="{{$data['city']}}" readonly/></td>
                          <td><input type="hidden" name="state" value="{{$data['state']}}" readonly/></td>
                          <td><input type="hidden" name="country" value="india" /></td>
                          <td><input type="hidden" name="zipcode" value="{{isset($data['zipcode']) ? $data['zipcode'] : ''}}" readonly/></td>
                          <td><input type="hidden" name="udf1" value="{{isset($data['udf1']) ? $data['udf1'] : ''}}" readonly/></td>
                          <td><input type="hidden" name="udf2" value="{{isset($data['udf2']) ? $data['udf2'] : ''}}" readonly/></td>
                          <td><input type="hidden" name="udf3" value="{{isset($data['udf3']) ? $data['udf3'] : ''}}" /></td>
                          <td><input type="hidden" name="udf4" value="{{isset($data['udf4']) ? $data['udf4'] : ''}}" /></td>
                          <td><input type="hidden" name="udf5" value="{{isset($data['udf5']) ? $data['udf5'] : ''}}" /></td>
                          <td><input type="hidden" name="pg" value="{{isset($data['pg']) ? $data['pg'] : ''}}" /></td>
                        </tr>
                         <tr>
                        	<td colspan="4"><input id="btnsubmit" type="submit" value="Submit" style="display:none;"  /></td>
                        </tr> 
                        </table>--}}


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{Html::script("js/jquery-1.8.3.min.js")}}
<script>
    $(document).ready(function () {
        $(".panel").hide();
        $("#btnsubmit").hide();
        document.forms.payuForm.submit();
    });
</script>
