@extends('app')
@section('content')
    <!-- Main Dashboard Content -->
    <main class="flex-1 p-6 custom-scrollbar overflow-y-auto">
        <!-- Welcome Section -->
        <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">
            Welcome back, John!
        </h2>
        <p class="text-gray-600">
            Here's what's happening with your business today.
        </p>
        </div>

        <!-- Stats Cards -->
        <div
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8"
        >
        <!-- Total Users -->
        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow"
        >
            <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">
                Total Users
                </p>
                <p class="text-3xl font-bold text-gray-800">12,345</p>
                <p class="text-sm text-green-600 mt-2">
                <span class="inline-flex items-center">
                    <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                    +12% from last month
                </span>
                </p>
            </div>
            <div
                class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center"
            >
                <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
            </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow"
        >
            <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">
                Total Revenue
                </p>
                <p class="text-3xl font-bold text-gray-800">$89,432</p>
                <p class="text-sm text-green-600 mt-2">
                <span class="inline-flex items-center">
                    <i data-lucide="trending-up" class="w-4 h-4 mr-1"></i>
                    +18% from last month
                </span>
                </p>
            </div>
            <div
                class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center"
            >
                <i
                data-lucide="dollar-sign"
                class="w-6 h-6 text-green-600"
                ></i>
            </div>
            </div>
        </div>

        <!-- Active s -->
        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow"
        >
            <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">Active s</p>
                <p class="text-3xl font-bold text-gray-800">24</p>
                <p class="text-sm text-blue-600 mt-2">
                <span class="inline-flex items-center">
                    <i data-lucide="activity" class="w-4 h-4 mr-1"></i>
                    8 completed this week
                </span>
                </p>
            </div>
            <div
                class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center"
            >
                <i data-lucide="folder" class="w-6 h-6 text-purple-600"></i>
            </div>
            </div>
        </div>

        <!-- New Messages -->
        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow"
        >
            <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 mb-1">
                New Messages
                </p>
                <p class="text-3xl font-bold text-gray-800">156</p>
                <p class="text-sm text-orange-600 mt-2">
                <span class="inline-flex items-center">
                    <i data-lucide="clock" class="w-4 h-4 mr-1"></i>
                    23 unread
                </span>
                </p>
            </div>
            <div
                class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center"
            >
                <i
                data-lucide="message-circle"
                class="w-6 h-6 text-orange-600"
                ></i>
            </div>
            </div>
        </div>
        </div>

        <!-- Charts and Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Sales Chart -->
        <div
            class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-200"
        >
            <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">
                Monthly Sales Trends
            </h3>
            <div class="flex space-x-2">
                <button
                class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-lg font-medium"
                >
                6M
                </button>
                <button
                class="px-3 py-1 text-sm text-gray-500 hover:bg-gray-100 rounded-lg"
                >
                1Y
                </button>
            </div>
            </div>
            <div class="h-80">
            <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Recent Activity -->
        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-200"
        >
            <h3 class="text-lg font-semibold text-gray-800 mb-6">
            Recent Activity
            </h3>
            <div class="space-y-4">
            <div class="flex items-start space-x-3">
                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                <div class="flex-1">
                <p class="text-sm font-medium text-gray-800">
                    New user registered
                </p>
                <p class="text-xs text-gray-500">
                    John Smith joined the platform
                </p>
                <p class="text-xs text-gray-400 mt-1">2 minutes ago</p>
                </div>
            </div>

            <div class="flex items-start space-x-3">
                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                <div class="flex-1">
                <p class="text-sm font-medium text-gray-800">
                    Payment received
                </p>
                <p class="text-xs text-gray-500">$2,400 from Acme Corp</p>
                <p class="text-xs text-gray-400 mt-1">15 minutes ago</p>
                </div>
            </div>

            <div class="flex items-start space-x-3">
                <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2"></div>
                <div class="flex-1">
                <p class="text-sm font-medium text-gray-800">updated</p>
                <p class="text-xs text-gray-500">
                    Website redesign progress: 85%
                </p>
                <p class="text-xs text-gray-400 mt-1">1 hour ago</p>
                </div>
            </div>

            <div class="flex items-start space-x-3">
                <div class="w-2 h-2 bg-purple-500 rounded-full mt-2"></div>
                <div class="flex-1">
                <p class="text-sm font-medium text-gray-800">New message</p>
                <p class="text-xs text-gray-500">
                    Sarah Wilson sent a message
                </p>
                <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                </div>
            </div>

            <div class="flex items-start space-x-3">
                <div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div>
                <div class="flex-1">
                <p class="text-sm font-medium text-gray-800">
                    Server alert
                </p>
                <p class="text-xs text-gray-500">High CPU usage detected</p>
                <p class="text-xs text-gray-400 mt-1">3 hours ago</p>
                </div>
            </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-200">
            <button
                class="w-full text-center text-sm text-blue-600 hover:text-blue-700 font-medium"
            >
                View all activity
            </button>
            </div>
        </div>
        </div>

        <!-- Recent Invoices Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">
                Recent Invoices
            </h3>
            <button
                id="add-invoice-btn"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
                <i data-lucide="plus" class="w-4 h-4 inline mr-2"></i>
                Add Invoice
            </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                    Invoice ID
                </th>
                <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                    Client
                </th>
                <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                    Amount
                </th>
                <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                    Status
                </th>
                <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                    Action
                </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr class="hover:bg-gray-50">
                <td
                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                >
                    #INV-001
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                    <img
                        src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="Client"
                        class="w-8 h-8 rounded-full mr-3"
                    />
                    <div>
                        <p class="text-sm font-medium text-gray-800">
                        Acme Corporation
                        </p>
                        <p class="text-xs text-gray-500">john@acme.com</p>
                    </div>
                    </div>
                </td>
                <td
                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                >
                    $2,400.00
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span
                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800"
                    >Paid</span
                    >
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <div class="flex space-x-2">
                    <button
                        class="text-blue-600 hover:text-blue-800 font-medium"
                    >
                        View
                    </button>
                    <button
                        class="text-gray-600 hover:text-gray-800 font-medium"
                    >
                        Edit
                    </button>
                    </div>
                </td>
                </tr>

                <tr class="hover:bg-gray-50">
                <td
                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                >
                    #INV-002
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                    <img
                        src="https://images.unsplash.com/photo-1494790108755-2616c0763c0c?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="Client"
                        class="w-8 h-8 rounded-full mr-3"
                    />
                    <div>
                        <p class="text-sm font-medium text-gray-800">
                        TechStart Inc
                        </p>
                        <p class="text-xs text-gray-500">
                        sarah@techstart.com
                        </p>
                    </div>
                    </div>
                </td>
                <td
                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                >
                    $1,800.00
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span
                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800"
                    >Pending</span
                    >
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <div class="flex space-x-2">
                    <button
                        class="text-blue-600 hover:text-blue-800 font-medium"
                    >
                        View
                    </button>
                    <button
                        class="text-gray-600 hover:text-gray-800 font-medium"
                    >
                        Edit
                    </button>
                    </div>
                </td>
                </tr>

                <tr class="hover:bg-gray-50">
                <td
                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                >
                    #INV-003
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                    <img
                        src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="Client"
                        class="w-8 h-8 rounded-full mr-3"
                    />
                    <div>
                        <p class="text-sm font-medium text-gray-800">
                        Design Studio
                        </p>
                        <p class="text-xs text-gray-500">
                        mike@designstudio.com
                        </p>
                    </div>
                    </div>
                </td>
                <td
                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                >
                    $3,200.00
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span
                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800"
                    >Overdue</span
                    >
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <div class="flex space-x-2">
                    <button
                        class="text-blue-600 hover:text-blue-800 font-medium"
                    >
                        View
                    </button>
                    <button
                        class="text-gray-600 hover:text-gray-800 font-medium"
                    >
                        Edit
                    </button>
                    </div>
                </td>
                </tr>

                <tr class="hover:bg-gray-50">
                <td
                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                >
                    #INV-004
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                    <img
                        src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="Client"
                        class="w-8 h-8 rounded-full mr-3"
                    />
                    <div>
                        <p class="text-sm font-medium text-gray-800">
                        Global Solutions
                        </p>
                        <p class="text-xs text-gray-500">
                        emily@globalsolutions.com
                        </p>
                    </div>
                    </div>
                </td>
                <td
                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
                >
                    $5,600.00
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span
                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800"
                    >Paid</span
                    >
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <div class="flex space-x-2">
                    <button
                        class="text-blue-600 hover:text-blue-800 font-medium"
                    >
                        View
                    </button>
                    <button
                        class="text-gray-600 hover:text-gray-800 font-medium"
                    >
                        Edit
                    </button>
                    </div>
                </td>
                </tr>
            </tbody>
            </table>
        </div>

        <div
            class="px-6 py-4 border-t border-gray-200 flex items-center justify-between"
        >
            <p class="text-sm text-gray-500">Showing 4 of 47 invoices</p>
            <div class="flex space-x-2">
            <button
                class="px-3 py-1 text-sm border border-gray-300 rounded text-gray-500 hover:bg-gray-50"
            >
                Previous
            </button>
            <button
                class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700"
            >
                Next
            </button>
            </div>
        </div>
        </div>
    </main>

@endsection

@push('more-content-stack')

    <!-- Add Invoice Modal -->
    <div
      id="add-invoice-modal"
      class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4"
    >
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
        <div
          class="flex items-center justify-between p-6 border-b border-gray-200"
        >
          <h3 class="text-lg font-semibold text-gray-800">Add New Invoice</h3>
          <button id="close-modal" class="text-gray-500 hover:text-gray-700">
            <i data-lucide="x" class="w-6 h-6"></i>
          </button>
        </div>

        <form class="p-6 space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2"
              >Client Name</label
            >
            <input
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="Enter client name"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2"
              >Email</label
            >
            <input
              type="email"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="client@example.com"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2"
              >Amount</label
            >
            <input
              type="number"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="0.00"
              step="0.01"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2"
              >Status</label
            >
            <select
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
              <option>Pending</option>
              <option>Paid</option>
              <option>Overdue</option>
            </select>
          </div>

          <div class="flex space-x-3 pt-4">
            <button
              type="button"
              id="cancel-modal"
              class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
              Create Invoice
            </button>
          </div>
        </form>
      </div>
    </div>


    <!-- Sidebar Overlay for Mobile -->
    <div
      id="sidebar-overlay"
      class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"
    ></div>
@endpush
