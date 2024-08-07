<span>
    <a  wire:click="add_admins" style="cursor:pointer;"><span class="Edit-Icon"> </span></a>


	<!-- The Modal -->
	<div class="modal fade" id="add_admin" wire:ignore.self>
		<div class="modal-dialog modal-xl">
			<div class="modal-content" >
				<!-- Modal Header -->
				<div class="modal-header">
				  <h1><span class="modal-title">Add Admin</span></h1>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<div class="container">
						<div class="row">
							<select id="category-dropdown" class="form-control" multiple  wire:model="admin_id">
								@foreach($user as $users)
									<option value="{{$users->id}}">{{$users->first_name}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
				  <button type="button" class="btn" wire:click="closeadminmodal" style="color:#fff; background-color:#003b5f;">Close</button>
				</div>
		  </div>
		</div>
	</div>
</span>


{{-- For add-admin................ --}}
<script>
  window.addEventListener('addadminModal', event=> {
     $('#add_admin').modal('show')
	 window.livewire.on('addteam', () => {
				$('#category-dropdown').select2();
			});
  })
</script>
<script>
  window.addEventListener('closeadminmodal', event=> {
     $('#add_admin').modal('hide')
  })
</script>

<script>
	window.onload = function() {
        Livewire.on('addadmin', () => {
			$('#category-dropdown').select2();
			$('#category-dropdown').on('change', function (e) {
				let data = $(this).val();
					@this.set('admin_id', data);
			});
			window.livewire.on('addadmin', () => {
				$('#category-dropdown').select2();
			});
        })
    }
</script>
{{-- For add-admin................ending --}}
