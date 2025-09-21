// Initialize Lucide icons
lucide.createIcons();

// Sidebar toggle functionality
const sidebarToggle = document.getElementById("sidebar-toggle");
const sidebarClose = document.getElementById("sidebar-close");
const sidebar = document.getElementById("sidebar");
const sidebarOverlay = document.getElementById("sidebar-overlay");

function showSidebar() {
  sidebar.classList.remove("-translate-x-full");
  sidebarOverlay.classList.remove("hidden");
}

function hideSidebar() {
  sidebar.classList.add("-translate-x-full");
  sidebarOverlay.classList.add("hidden");
}

sidebarToggle?.addEventListener("click", showSidebar);
sidebarClose?.addEventListener("click", hideSidebar);
sidebarOverlay?.addEventListener("click", hideSidebar);

// Dropdown functionality
function setupDropdown(buttonId, dropdownId) {
  const button = document.getElementById(buttonId);
  const dropdown = document.getElementById(dropdownId);

  if (button && dropdown) {
    button.addEventListener("click", (e) => {
      e.stopPropagation();
      // Close other dropdowns
      document.querySelectorAll('[id$="-dropdown"]').forEach((d) => {
        if (d !== dropdown) d.classList.add("hidden");
      });
      dropdown.classList.toggle("hidden");
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", () => {
      dropdown.classList.add("hidden");
    });

    dropdown.addEventListener("click", (e) => {
      e.stopPropagation();
    });
  }
}

setupDropdown("notifications-btn", "notifications-dropdown");
setupDropdown("user-menu-btn", "user-dropdown");

// Modal functionality
const addInvoiceBtn = document.getElementById("add-invoice-btn");
const addInvoiceModal = document.getElementById("add-invoice-modal");
const closeModal = document.getElementById("close-modal");
const cancelModal = document.getElementById("cancel-modal");

function showModal() {
  addInvoiceModal?.classList.remove("hidden");
}

function hideModal() {
  addInvoiceModal?.classList.add("hidden");
}

addInvoiceBtn?.addEventListener("click", showModal);
closeModal?.addEventListener("click", hideModal);
cancelModal?.addEventListener("click", hideModal);

// Close modal when clicking outside
addInvoiceModal?.addEventListener("click", (e) => {
  if (e.target === addInvoiceModal) {
    hideModal();
  }
});

// Chart initialization
window.addEventListener("load", () => {
  const ctx = document.getElementById("salesChart");
  if (ctx) {
    new Chart(ctx, {
      type: "line",
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
        datasets: [
          {
            label: "Sales",
            data: [12000, 19000, 15000, 25000, 22000, 30000],
            borderColor: "rgb(59, 130, 246)",
            backgroundColor: "rgba(59, 130, 246, 0.1)",
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: "rgb(59, 130, 246)",
            pointBorderColor: "#fff",
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              color: "rgba(0, 0, 0, 0.1)",
            },
            ticks: {
              callback: function (value) {
                return "$" + value.toLocaleString();
              },
            },
          },
          x: {
            grid: {
              display: false,
            },
          },
        },
      },
    });
  }
});

// Handle form submission
document
  .querySelector("#add-invoice-modal form")
  ?.addEventListener("submit", (e) => {
    e.preventDefault();
    // Here you would normally send the data to your backend
    alert("Invoice created successfully!");
    hideModal();
  });

// Handle responsive behavior
window.addEventListener("resize", () => {
  if (window.innerWidth >= 1024) {
    hideSidebar();
  }
});
