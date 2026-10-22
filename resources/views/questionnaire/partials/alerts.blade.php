@if (session('questionnaire_error'))
    <x-ui.alert tone="warning" class="mb-6">{{ session('questionnaire_error') }}</x-ui.alert>
@endif

@if ($errors->any())
    <x-ui.alert tone="danger" class="mb-6" title="Periksa kembali">
        <ul class="list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-ui.alert>
@endif
