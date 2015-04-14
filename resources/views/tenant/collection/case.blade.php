@extends('tenant.layouts.main')

@section('heading')
Court Case
@stop

@section('content')
    <div class="callout callout-info">
	    <p>Creating a court case is easy just follow the steps below and we'll create all the documents you need to fill out. We have even completed step 1 for you already!</p>
	</div>
    <div class="box box-solid">
        <div class="box-body">
        	

            <div class="row">
            	<div class="col-md-12">
            		<ol class="pad-left-20">
            			<li>
            				<p>To the document that you have followed the required steps in the collection process we have added the bill and late payment notices you have sent:</p>
            				<ul class="pad-0 imgaes-row">
            					<li>
            						<span class="img-box-small">
            								
            						</span>
            						<span class="text-middle">Purring.pdf</span>
            					</li>
            					<li>
            						<span class="img-box-small">
            								
            						</span>
            						<span class="text-middle">Purring.pdf</span>
            						
            					</li>
            					<li>
            						<span class="img-box-small">
            								
            						</span>
            						<span class="text-middle">Purring.pdf</span>
            						
            					</li>
            					<li>
            						<span class="img-box-small">
            								
            						</span>
            						<span class="text-middle">Purring.pdf</span>
            						
            					</li>
            				</ul>
        				</li>
        				<li>
        					<p>It's important to document the contract, order forms and other documentation:</p>
        					<div class="list-bx">
        						<p><strong>List of documents on customer card</strong></p>

	        					<ul class="pad-left-20">
	        						<li>List 1</li>
	        						<li>List 2</li>
	        						<li>List 3</li>
	        					</ul>
        					</div>
        					<p>Select other to add</p>

        				</li>
        				<li>
        					<p>Now let's make the case stick by adding all the communication relevant for the case</p>
        					<div class="list-bx">
        						<p><strong>List of emails filtered onto the customer</strong></p>

	        					<ul class="pad-left-20">
	        						<li>List 1</li>
	        						<li>List 2</li>
	        						<li>List 3</li>
	        					</ul>
        					</div>
        				</li>
        				<li>
        					<p>Now let's make the case stick by adding all the communication relevant for the case</p>
        					<textarea class="list-bx" placeholder="Write an explanation here about what happened">
        						
        					</textarea> 
        				</li>
            		</ol>
            		<p class="col-md-6 align-right">
            			<a href="#" class="btn btn-primary">Create Debt</a>
            			<a href="#" class="btn btn-danger">Cancel</a>
            		</p>
            	</div>		
        	</div>
        </div>
    </div>


{{--Load JS--}}
{{FB::registerModal()}}

@stop</p>