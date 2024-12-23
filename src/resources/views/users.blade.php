<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">All Users</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Is Enabled?</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b border-gray-200">
                            <td class="px-6 py-3 text-sm text-gray-800">{{ $user->name }}</td>
                            <td class="px-6 py-3 text-sm text-gray-800">{{ $user->email }}</td>
                            <td class="px-6 py-3 text-sm" x-data="{ loading: false }">
                                <div class="flex items-center justify-start gap-2">
                                    <label for="user-{{ $user->getKey() }}-toggle">
                                        <input
                                            type="checkbox"
                                            id="user-{{ $user->getKey() }}-toggle"
                                            x-bind:checked="@js($user->enabled)"
                                            x-bind:disabled="loading"
                                            x-on:change="async () => {
                                                const checked = $event.target.checked;

                                                loading = true;

                                                try {
                                                    await axios.post(`/users/${checked ? 'enable' : 'disable'}/{{ $user->getKey() }}`);
                                                } catch (error) {
                                                    alert('An error occurred: ' + (error.response?.data?.message || error.message));
                                                    $event.target.checked = ! checked;
                                                } finally {
                                                    loading = false;
                                                }
                                            }"
                                        />
                                        <span class="sr-only">Toggle User Status</span>
                                    </label>
                                    <!-- Loading Spinner -->
                                    <svg
                                        x-show="loading"
                                        x-cloak
                                        class="animate-spin size-5 text-gray-500"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle
                                            class="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"
                                        ></circle>
                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                        ></path>
                                    </svg>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
