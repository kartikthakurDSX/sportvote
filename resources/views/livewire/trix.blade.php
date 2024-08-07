<div wire:ignore>
    <link rel="stylesheet" href="{{url('frontend/css/trix.min.css')}}" />

    <input id="{{ $trixId }}" type="hidden" name="content" value="{{ $value }}" >
    <trix-editor input="{{ $trixId }}" class="text_editor_desc_color" ></trix-editor>

    <script src="{{url('frontend/js/trix.min.js')}}"></script>

	<script>
		var trixEditor = document.getElementById("{{ $trixId }}")

		addEventListener("trix-change", function(event) {
			@this.set('value', trixEditor.getAttribute('value'))
		})
	</script>
</div>
