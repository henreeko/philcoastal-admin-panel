<div class="h-full w-full flex-1">

    <div class="mb-4">
        <flux:button variant="primary" wire:click="createUser">Create</flux:button>
    </div>

    <div class="overflow-x-auto rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700">
<div class="relative">

<div class="overflow-x-auto rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700">
    <table class="min-w-full text-sm text-left table-auto">
        <thead class="bg-gray-50 dark:bg-zinc-800 uppercase text-xs font-semibold text-gray-600 dark:text-zinc-300">
            <tr>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-zinc-700">
            @forelse ($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800 transition">
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-gray-700 dark:text-zinc-300">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <flux:button wire:click="viewUser({{ $user->id }})">View</flux:button>
                        <flux:button wire:click="editUser({{ $user->id }})">Edit</flux:button>
                        <flux:button variant="danger" wire:click="deleteUser({{ $user->id }})" wire:confirm="Are you sure?">Delete</flux:button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-6 text-center text-gray-400 dark:text-zinc-500">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
    </div>
        <div class="mt-4 px-6">
            {{ $users->links() }}
                </div>

{{-- Edit/Create Modal --}}
@if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-md bg-white/10 dark:bg-black/10">
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <flux:heading class="mb-4 text-lg font-semibold text-center">
                {{ $isEditing ? 'Edit User' : 'Create User' }}
            </flux:heading>

            <form wire:submit.prevent="saveUser" class="space-y-4">
                <flux:input
                    label="Name"
                    wire:model.defer="name"
                    placeholder="Full name"
                />

                <flux:input
                    label="Email"
                    type="email"
                    wire:model.defer="email"
                    placeholder="user@example.com"
                />

                @unless($isEditing)
                    <flux:input
                        label="Password"
                        type="password"
                        wire:model.defer="password"
                        placeholder="********"
                    />

                    <flux:input
                        label="Confirm Password"
                        type="password"
                        wire:model.defer="password_confirmation"
                        placeholder="********"
                    />
                @endunless

                <div class="flex justify-end space-x-2 pt-4">
                    <flux:button variant="filled" type="button" wire:click="closeModal" class="cursor-pointer">
                        Cancel
                    </flux:button>
                    <flux:button variant="primary" type="submit" class="cursor-pointer">
                        {{ $isEditing ? 'Update' : 'Create' }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
@endif

{{-- View Modal --}}
@if($showViewModal && $viewingUser)
    <div class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-md bg-white/10 dark:bg-black/10">
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <flux:heading class="mb-4 text-lg font-semibold text-center">
                User Details
            </flux:heading>

            <div class="space-y-3 text-sm text-gray-800 dark:text-zinc-200">
                <div><strong>Name:</strong> {{ $viewingUser->name }}</div>
                <div><strong>Email:</strong> {{ $viewingUser->email }}</div>
                <div><strong>Created At:</strong> {{ $viewingUser->created_at->format('F j, Y h:i A') }}</div>
                <div><strong>Updated At:</strong> {{ $viewingUser->updated_at->format('F j, Y h:i A') }}</div>
            </div>

            <div class="flex justify-end space-x-2 pt-6">
                <flux:button variant="filled" type="button" wire:click="closeViewModal" class="cursor-pointer">
                    Close
                </flux:button>
            </div>
        </div>
    </div>
@endif


</div>
