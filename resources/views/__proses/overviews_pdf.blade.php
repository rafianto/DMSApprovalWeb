<html>
<head>
	<title>{{ $idd }} PDF</title>
	<link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style> 
	<center>
		<h5>Membuat Laporan PDF DMS No {{ $idd }}</h4>
		<h6><a target="_blank" href="#">dms2.mbs.co.id</a></h5>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				 <th>dms_no</th>
                 <th>create_date</th>
                 <th>date_from</th>
                 <th>date_to</th>
                 <th>princ_code</th>
                 <th>ce_max</th>
                 <th>pe_max</th>
                 <th>prod_group_major</th>
                 <th>state</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($dmoverview as $ovh)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{ $ovh->dms_no }}</td>
                <td>{{ $ovh->created_date }}</td>
                <td>{{ $ovh->date_from }}</td>
                <td>{{ $ovh->date_to }}</td>
                <td>{{ $ovh->principal }}</td>
                <td>{{ $ovh->cemax }}</td>
                <td>{{ $ovh->pemax }}</td>
                <td>{{ $ovh->prdgrpm }}</td>
                <td>{{ $ovh->state }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>