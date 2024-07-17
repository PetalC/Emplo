<div x-data="{isChecked: false}">
    <div class="rounded-lg flex flex-col lg:flex-row items-center p-5 border border-gray-500 gap-10">
        <input type="checkbox" x-model="$props.isChecked" class="w-5 h-5 rounded-lg">
        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-10">
            <div class="w-24 h-24 bg-gray-200 rounded-lg">
                <x-icon name="heroicon-o-user" class="text-white p-4"/> 
            </div>
            <div class="text-app w-64">
                <p class="text-2xl text-center lg:text-left">Jane Manor</p>
                <p class="text-gray-300 mt-2 text-center lg:text-left">Brisbane, QueensLand, Australia 12km away</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-5 lg:w-5/12 w-full justify-center lg:justify-start">
            <x-app.staffroom.candidate-type label="Teaching" />
            <x-app.staffroom.candidate-type label="Mathematics" />
            <x-app.staffroom.candidate-type label="Chemistry" />
            <x-app.staffroom.candidate-type label="Physics" />
        </div>
        <div class="flex gap-5">   
            <x-app.staffroom.guard-item label="SD"/>
            <x-app.staffroom.guard-item label="R" />
            <x-app.staffroom.guard-item label="TR"/>
            <x-app.staffroom.guard-item label="ID"/>
            <x-app.staffroom.guard-item label="CC" enabled="{{false}}" />
        </div>
    </div>
</div>
