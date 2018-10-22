@extends('v2.layouts.app')

@section('title', 'FacebookTracker')

@section('content')

	<?php foreach($campaigns as $campaign): ?>
	
		<?php echo 'Campign Name'.$campaign->name .'<br><br>';?> 
		
		<script>
		
			fbq('track', 'Existing Customer - Design Request');
			
		</script>
	<?php endforeach; ?>

	<?php foreach($orders as $order): ?>
	
	<?php echo 'Order coustomer  Name'.$order->contact_first_name .'<br><br>';?> 
	 
		<script>
		
			fbq('track', 'Existing Customer - Purchase');
			
		</script>	
		
	<?php endforeach; ?>
	
@endsection