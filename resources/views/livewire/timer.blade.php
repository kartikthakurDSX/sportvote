<div wire:poll.1s>
    @if (Auth::check()) {{-- Checks if the user is logged in or not --}}
    <?php $lapse_type = App\Models\Match_fixture_lapse::where('match_fixture_id', $match_fixture->id)
        ->where('lapse_type', 2)
        ->get(); ?>
        @if (count($lapse_type) < 1) {{-- To check if to start first half or second half of the match --}}
            @if (!$isActive && $firstHalfComplete == 0)
                <button wire:click="startTimer">Start First Half<div id="timer">{{ gmdate('H:i:s', $elapsedTime) }}</div></button>
            @elseif ($isActive && !$isPaused)
                <button wire:click="pauseTimer">Pause First Half<div id="timer">{{ gmdate('H:i:s', $elapsedTime) }}</div></button>
            @else
                <button wire:click="resumeTimer">Resume First Half<div id="timer">{{ gmdate('H:i:s', $elapsedTime) }}</div></button>
            @endif
        @else
        @if (!$isActive && $firstHalfComplete == 1)
                <button wire:click="startSecondTimer">Start Second Half<div id="timer">{{ gmdate('H:i:s', $elapsedTime) }}</div></button>
            @elseif ($isActive && !$isPaused)
                <button wire:click="pauseSecondTimer">Pause Second Half<div id="timer">{{ gmdate('H:i:s', $elapsedTime) }}</div></button>
            @else
                <button wire:click="resumeSecondTimer">Resume Second Half<div id="timer">{{ gmdate('H:i:s', $elapsedTime) }}</div></button>
            @endif
        @endif
    @endif
</div>
