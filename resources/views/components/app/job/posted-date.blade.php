<div class="flex items-center gap-2 justify-center">
    <x-icon name="heroicon-o-clock" class="w-6 h-6 text-gray-300" />
    <span>{{ (new \Moment\Moment($job->created_at->toDateString()))->fromNow()->getRelative() }}</span>
</div>
