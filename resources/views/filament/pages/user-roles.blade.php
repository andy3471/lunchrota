<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <x-filament::section>
            <x-slot name="heading">
                Select Date
            </x-slot>

            <x-filament::input.wrapper>
                <input
                    type="date"
                    wire:model.lazy="date"
                    wire:change="getUserRoles"
                    class="block w-full transition duration-75 rounded-lg shadow-sm border-gray-300 focus:border-primary-600 focus:ring focus:ring-primary-600 focus:ring-opacity-50"
                />
            </x-filament::input.wrapper>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                User Roles
            </x-slot>

            <div class="overflow-x-auto">
                <table class="w-full text-left table-auto">
                    <tbody>
                    @foreach($this->users as $user)
                        <tr>
                            <td class="border px-4 py-2 w-1/2">{{ $user->name }}</td>
                            <td class="border px-4 py-2 w-1/2">
                                <x-filament::input.wrapper>
                                    <x-filament::input.select
                                        wire:model="userRoles.{{ $user->id }}"
                                        wire:change="updateUserRole({{ $user->id }})"
                                    >
                                        <option value="none">Select Role</option>
                                        @foreach($this->roles as $role)
                                            <option value="{{ $role->id }}">
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </x-filament::input.select>
                                </x-filament::input.wrapper>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
