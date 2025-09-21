let teamMembers = [
  {
    id: 1,
    firstName: "John",
    lastName: "Doe",
    email: "john.doe@company.com",
    phone: "+1 (555) 123-4567",
    role: "Manager",
    department: "Engineering",
    status: "Active",
    joined: "2023-01-15",
    avatar: "https://via.placeholder.com/40",
  },
  {
    id: 2,
    firstName: "Jane",
    lastName: "Smith",
    email: "jane.smith@company.com",
    phone: "+1 (555) 234-5678",
    role: "Developer",
    department: "Engineering",
    status: "Active",
    joined: "2023-02-20",
    avatar: "https://via.placeholder.com/40",
  },
  {
    id: 3,
    firstName: "Mike",
    lastName: "Johnson",
    email: "mike.johnson@company.com",
    phone: "+1 (555) 345-6789",
    role: "Designer",
    department: "Design",
    status: "Active",
    joined: "2023-03-10",
    avatar: "https://via.placeholder.com/40",
  },
  {
    id: 4,
    firstName: "Sarah",
    lastName: "Wilson",
    email: "sarah.wilson@company.com",
    phone: "+1 (555) 456-7890",
    role: "Analyst",
    department: "Marketing",
    status: "Inactive",
    joined: "2023-04-05",
    avatar: "https://via.placeholder.com/40",
  },
];

let currentEditId = null;
let deleteId = null;

// Sidebar functionality
const sidebarToggle = document.getElementById("sidebarToggle");
const sidebar = document.getElementById("sidebar");

sidebarToggle.addEventListener("click", () => {
  sidebar.classList.toggle("-translate-x-full");
});

// Dropdown functionality
const notificationBtn = document.getElementById("notificationBtn");
const notificationDropdown = document.getElementById("notificationDropdown");
const userMenuBtn = document.getElementById("userMenuBtn");
const userDropdown = document.getElementById("userDropdown");

notificationBtn.addEventListener("click", (e) => {
  e.stopPropagation();
  notificationDropdown.classList.toggle("hidden");
  userDropdown.classList.add("hidden");
});

userMenuBtn.addEventListener("click", (e) => {
  e.stopPropagation();
  userDropdown.classList.toggle("hidden");
  notificationDropdown.classList.add("hidden");
});

document.addEventListener("click", () => {
  notificationDropdown.classList.add("hidden");
  userDropdown.classList.add("hidden");
});

// Modal functionality
const teamMemberModal = document.getElementById("teamMemberModal");
const deleteModal = document.getElementById("deleteModal");
const addTeamMemberBtn = document.getElementById("addTeamMemberBtn");
const closeModal = document.getElementById("closeModal");
const cancelBtn = document.getElementById("cancelBtn");
const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");
const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
const teamMemberForm = document.getElementById("teamMemberForm");
const modalTitle = document.getElementById("modalTitle");

// Render team members table
function renderTeamMembers() {
  const tbody = document.getElementById("teamTableBody");
  tbody.innerHTML = "";

  teamMembers.forEach((member) => {
    const row = document.createElement("tr");
    row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <img class="h-10 w-10 rounded-full" src="${
                              member.avatar
                            }" alt="${member.firstName} ${member.lastName}">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${
                                  member.firstName
                                } ${member.lastName}</div>
                                <div class="text-sm text-gray-500">${
                                  member.email
                                }</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${
                      member.role
                    }</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${
                      member.department
                    }</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                          member.status === "Active"
                            ? "bg-green-100 text-green-800"
                            : "bg-red-100 text-red-800"
                        }">
                            ${member.status}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${new Date(
                      member.joined
                    ).toLocaleDateString()}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="editMember(${
                          member.id
                        })" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button onclick="deleteMember(${
                          member.id
                        })" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                `;
    tbody.appendChild(row);
  });
}

// Add team member
addTeamMemberBtn.addEventListener("click", () => {
  currentEditId = null;
  modalTitle.textContent = "Add Team Member";
  teamMemberForm.reset();
  teamMemberModal.classList.remove("hidden");
});

// Edit member
function editMember(id) {
  const member = teamMembers.find((m) => m.id === id);
  if (member) {
    currentEditId = id;
    modalTitle.textContent = "Edit Team Member";
    document.getElementById("firstName").value = member.firstName;
    document.getElementById("lastName").value = member.lastName;
    document.getElementById("email").value = member.email;
    document.getElementById("phone").value = member.phone;
    document.getElementById("role").value = member.role;
    document.getElementById("department").value = member.department;
    teamMemberModal.classList.remove("hidden");
  }
}

// Delete member
function deleteMember(id) {
  deleteId = id;
  deleteModal.classList.remove("hidden");
}

// Close modals
closeModal.addEventListener("click", () => {
  teamMemberModal.classList.add("hidden");
});

cancelBtn.addEventListener("click", () => {
  teamMemberModal.classList.add("hidden");
});

cancelDeleteBtn.addEventListener("click", () => {
  deleteModal.classList.add("hidden");
});

// Confirm delete
confirmDeleteBtn.addEventListener("click", () => {
  teamMembers = teamMembers.filter((m) => m.id !== deleteId);
  renderTeamMembers();
  deleteModal.classList.add("hidden");
});

// Form submission
teamMemberForm.addEventListener("submit", (e) => {
  e.preventDefault();

  const formData = {
    firstName: document.getElementById("firstName").value,
    lastName: document.getElementById("lastName").value,
    email: document.getElementById("email").value,
    phone: document.getElementById("phone").value,
    role: document.getElementById("role").value,
    department: document.getElementById("department").value,
    status: "Active",
    avatar: "https://via.placeholder.com/40",
  };

  if (currentEditId) {
    // Edit existing member
    const memberIndex = teamMembers.findIndex((m) => m.id === currentEditId);
    if (memberIndex !== -1) {
      teamMembers[memberIndex] = {
        ...teamMembers[memberIndex],
        ...formData,
      };
    }
  } else {
    // Add new member
    const newId = Math.max(...teamMembers.map((m) => m.id)) + 1;
    teamMembers.push({
      id: newId,
      ...formData,
      joined: new Date().toISOString().split("T")[0],
    });
  }

  renderTeamMembers();
  teamMemberModal.classList.add("hidden");
});

// Close modals when clicking outside
teamMemberModal.addEventListener("click", (e) => {
  if (e.target === teamMemberModal) {
    teamMemberModal.classList.add("hidden");
  }
});

deleteModal.addEventListener("click", (e) => {
  if (e.target === deleteModal) {
    deleteModal.classList.add("hidden");
  }
});

// Initial render
renderTeamMembers();
