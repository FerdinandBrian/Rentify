<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">
                    Welcome back, {{ Auth::user()->name }} 👋
                </h3>
                <p class="text-gray-600 dark:text-gray-300 mt-2">
                    Manage your events, tickets, and transactions from this dashboard.
                </p>
            </div>

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h4 class="text-gray-500 text-sm">Total Events</h4>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">
                        {{ $totalEvents ?? 0 }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h4 class="text-gray-500 text-sm">Tickets Sold</h4>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">
                        {{ $ticketsSold ?? 0 }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h4 class="text-gray-500 text-sm">Total Users</h4>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">
                        {{ $totalUsers ?? 0 }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h4 class="text-gray-500 text-sm">Revenue</h4>
                    <p class="text-3xl font-bold text-green-600 mt-2">
                        Rp {{ number_format($revenue ?? 0) }}
                    </p>
                </div>

            </div>

            <!-- Recent Events -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                    Recent Events
                </h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="px-4 py-2 text-left">Event Name</th>
                                <th class="px-4 py-2 text-left">Date</th>
                                <th class="px-4 py-2 text-left">Location</th>
                                <th class="px-4 py-2 text-left">Tickets</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($events ?? [] as $event)
                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                <td class="px-4 py-2">{{ $event->name }}</td>
                                <td class="px-4 py-2">{{ $event->date }}</td>
                                <td class="px-4 py-2">{{ $event->location }}</td>
                                <td class="px-4 py-2">{{ $event->tickets }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">
                                    No events available
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                    Recent Transactions
                </h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="px-4 py-2">User</th>
                                <th class="px-4 py-2">Event</th>
                                <th class="px-4 py-2">Tickets</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($transactions ?? [] as $trx)
                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                <td class="px-4 py-2">{{ $trx->user }}</td>
                                <td class="px-4 py-2">{{ $trx->event }}</td>
                                <td class="px-4 py-2">{{ $trx->tickets }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($trx->total) }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 bg-green-500 text-white text-xs rounded">
                                        {{ $trx->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">
                                    No transactions yet
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                    Quick Actions
                </h3>

                <div class="flex flex-wrap gap-4">
                    <a href="/events/create"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Create Event
                    </a>

                    <a href="/events"
                       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Manage Events
                    </a>

                    <a href="/transactions"
                       class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                        View Transactions
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>