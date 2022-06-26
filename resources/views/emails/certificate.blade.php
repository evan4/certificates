
@extends('emails.layouts.home', ['title' => $details['theme'] ] )

@section('content')
<td valign="middle" class="intro bg_white" style="padding: 2em 0 4em 0;">
    <h1>{{$details['theme']}}</h1>
	<table>
		<tbody>
			<tr>
					<p> Email {{$details['email']}} </p>
					<p> Name {{$details['first_name']}} </p>
					<p> Last name {{$details['last_name']}} </p>
					<p> Tree amount {{$details['tree_amount']}} </p>
					<p> Plantation {{$details['plantation']}} </p>
					<p> Payment {{$details['paymentOption']}} </p>
					<p> Amount {{$details['amount']}} </p>
					<p> Verification code {{$details['code']}} </p>
			</tr>
		</tbody>
	</table>
</td>
@endsection
