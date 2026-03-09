/**
 * NexaDash — Shared Sidebar Component
 * Inject sidebar + topbar HTML into any page.
 * Usage: <script src="_sidebar.js"></script>
 *        Call: initSidebar({ page: 'dashboard', title: 'Dashboard' })
 */

function initSidebar({ page = 'dashboard', title = 'Dashboard' } = {}) {

  // ─── Sidebar HTML ───
  const sidebarHTML = `
<aside class="sidebar" :class="collapsed && 'collapsed'">
  <!-- Logo -->
  <div style="padding:20px 18px 14px;border-bottom:1px solid var(--border);">
    <div style="display:flex;align-items:center;gap:10px;">
      <div style="width:36px;height:36px;background:#059669;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(5,150,105,0.3);">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="white" stroke-width="2.2" stroke-linejoin="round"/></svg>
      </div>
      <div class="logo-text">
        <div style="font-size:15px;font-weight:800;color:var(--text);letter-spacing:-0.03em;">NexaDash</div>
        <div style="font-size:11px;color:var(--muted-light);">Starter Kit v2.0</div>
      </div>
    </div>
  </div>

  <!-- Nav -->
  <nav style="flex:1;overflow-y:auto;padding:12px 10px;">
    <span class="section-label">Main Menu</span>

    <a class="nav-item ${page==='dashboard'?'active':''}" href="dashboard.html">
      <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
      <span class="nav-label">Dashboard</span>
    </a>

    <!-- Analytics submenu -->
    <div x-data="{ open: ${page==='analytics'?'true':'false'} }">
      <a class="nav-item ${page==='analytics'?'active':''}" @click="open = !open" style="cursor:pointer;">
        <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M7 16l4-4 4 4 4-7"/></svg>
        <span class="nav-label" style="flex:1;">Analytics</span>
        <svg class="nav-arrow nav-label" :style="open && 'transform:rotate(180deg)'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
      </a>
      <div x-show="open" x-transition.opacity.duration.200ms style="overflow:hidden;">
        <a class="sub-item" href="analytics.html">Overview</a>
        <a class="sub-item" href="analytics.html">Reports</a>
        <a class="sub-item" href="analytics.html">Realtime</a>
      </div>
    </div>

    <!-- Users submenu -->
    <div x-data="{ open: ${page==='users'?'true':'false'} }">
      <a class="nav-item ${page==='users'?'active':''}" @click="open = !open" style="cursor:pointer;">
        <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        <span class="nav-label" style="flex:1;">Users</span>
        <svg class="nav-arrow nav-label" :style="open && 'transform:rotate(180deg)'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
      </a>
      <div x-show="open" x-transition.opacity.duration.200ms style="overflow:hidden;">
        <a class="sub-item" href="users.html">All Users</a>
        <a class="sub-item" href="users.html">Roles</a>
        <a class="sub-item" href="users.html">Permissions</a>
      </div>
    </div>

    <a class="nav-item ${page==='orders'?'active':''}" href="orders.html">
      <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
      <span class="nav-label" style="flex:1;">Orders</span>
      <span class="nav-badge nav-label">12</span>
    </a>

    <a class="nav-item ${page==='kanban'?'active':''}" href="kanban.html">
      <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="5" height="18" rx="1.5"/><rect x="10" y="3" width="5" height="12" rx="1.5"/><rect x="17" y="3" width="5" height="15" rx="1.5"/></svg>
      <span class="nav-label" style="flex:1;">Kanban</span>
      <span class="nav-badge orange nav-label">5</span>
    </a>

    <span class="section-label" style="margin-top:4px;">Interface</span>

    <a class="nav-item ${page==='components'?'active':''}" href="components.html">
      <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 2l9 4.5v9L12 20l-9-4.5v-9L12 2z"/><path d="M12 2v18M3 6.5l9 4.5 9-4.5"/></svg>
      <span class="nav-label">UI Components</span>
    </a>

    <a class="nav-item ${page==='forms'?'active':''}" href="forms.html">
      <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
      <span class="nav-label">Forms</span>
    </a>

    <a class="nav-item ${page==='pricing'?'active':''}" href="pricing.html">
      <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
      <span class="nav-label">Pricing</span>
    </a>

    <span class="section-label" style="margin-top:4px;">Account</span>

    <a class="nav-item ${page==='settings'?'active':''}" href="settings.html">
      <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2"/></svg>
      <span class="nav-label">Settings</span>
    </a>
  </nav>

  <!-- Footer -->
  <div style="padding:14px 18px;border-top:1px solid var(--border);">
    <div style="display:flex;align-items:center;gap:10px;">
      <div class="avatar" style="width:34px;height:34px;background:linear-gradient(135deg,#059669,#10b981);color:white;font-size:12px;flex-shrink:0;">JD</div>
      <div class="sidebar-footer-text" style="flex:1;min-width:0;">
        <div style="font-size:13px;font-weight:700;color:var(--text);">John Doe</div>
        <div style="font-size:11px;color:var(--muted-light);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">john@nexadash.io</div>
      </div>
      <a href="settings.html" class="btn btn-icon btn-secondary sidebar-footer-text" style="padding:6px;">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
      </a>
    </div>
  </div>
</aside>`;

  // ─── Topbar HTML ───
  const topbarHTML = `
<div class="topbar">
  <button @click="collapsed = !collapsed" class="btn btn-icon btn-secondary">
    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
  </button>
  <div class="breadcrumb">
    <a href="dashboard.html">Home</a>
    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
    <span class="current">${title}</span>
  </div>
  <div class="input-wrap" style="flex:1;max-width:280px;margin-left:auto;">
    <svg class="i-left" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
    <input type="text" class="form-input has-left" placeholder="Search..."/>
  </div>
  <div style="display:flex;align-items:center;gap:8px;">
    <!-- Notification Dropdown -->
    <div x-data="{ open: false }" style="position:relative;">
      <button @click="open = !open" class="btn btn-icon btn-secondary" style="position:relative;">
        <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
        <span class="notif-dot"></span>
      </button>
      <div x-show="open" @click.outside="open = false" x-transition class="dropdown" style="width:280px;right:0;">
        <div style="padding:10px 14px;font-size:14px;font-weight:700;">Notifications</div>
        <div style="height:1px;background:var(--border);margin:0 8px;"></div>
        <a class="dropdown-item" style="margin-top:4px;"><div style="width:8px;height:8px;background:#059669;border-radius:50%;flex-shrink:0;"></div><div><p style="font-size:13px;font-weight:500;">New user registered</p><p style="font-size:11px;color:var(--muted-light);margin-top:1px;">2 min ago</p></div></a>
        <a class="dropdown-item"><div style="width:8px;height:8px;background:#f97316;border-radius:50%;flex-shrink:0;"></div><div><p style="font-size:13px;font-weight:500;">Order #1042 completed</p><p style="font-size:11px;color:var(--muted-light);margin-top:1px;">18 min ago</p></div></a>
        <a class="dropdown-item"><div style="width:8px;height:8px;background:#ef4444;border-radius:50%;flex-shrink:0;"></div><div><p style="font-size:13px;font-weight:500;">Payment #893 failed</p><p style="font-size:11px;color:var(--muted-light);margin-top:1px;">3 hours ago</p></div></a>
      </div>
    </div>
    <div style="width:1px;height:24px;background:var(--border);"></div>
    <!-- User Dropdown -->
    <div x-data="{ open: false }" style="position:relative;">
      <div @click="open = !open" style="display:flex;align-items:center;gap:8px;padding:4px 8px;border-radius:10px;cursor:pointer;transition:background 0.15s;" @mouseenter="$el.style.background='#f0fdf4'" @mouseleave="$el.style.background=''">
        <div class="avatar" style="width:30px;height:30px;background:linear-gradient(135deg,#059669,#10b981);color:white;font-size:11px;">JD</div>
        <span style="font-size:13px;font-weight:600;color:var(--text);">John Doe</span>
        <svg :style="open && 'transform:rotate(180deg)'" style="transition:transform 0.2s;" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
      </div>
      <div x-show="open" @click.outside="open = false" x-transition class="dropdown" style="width:200px;">
        <a class="dropdown-item" href="settings.html"><svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>My Profile</a>
        <a class="dropdown-item" href="settings.html"><svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>Settings</a>
        <div style="height:1px;background:var(--border);margin:4px 0;"></div>
        <a class="dropdown-item" style="color:#ef4444;"><svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>Logout</a>
      </div>
    </div>
  </div>
</div>`;

  // ─── Modal HTML ───
  const modalHTML = `
<div x-show="modal" x-transition.opacity.duration.200ms class="modal-overlay" @click.self="modal = false" x-cloak>
  <div class="modal-box" @click.stop x-show="modal" x-transition.scale.origin.center>
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:22px;">
      <div>
        <h3 style="font-size:17px;font-weight:800;letter-spacing:-0.02em;">Add New User</h3>
        <p style="font-size:13px;color:var(--muted);margin-top:3px;">Fill in the details to create a user.</p>
      </div>
      <button @click="modal = false" class="btn btn-icon btn-secondary" style="margin-top:-4px;"><svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
    </div>
    <div style="display:flex;flex-direction:column;gap:14px;">
      <div><label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Full Name</label><div class="input-wrap"><svg class="i-left" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><input type="text" class="form-input has-left" placeholder="John Doe"/></div></div>
      <div><label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Email</label><div class="input-wrap"><svg class="i-left" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg><input type="email" class="form-input has-left" placeholder="john@example.com"/></div></div>
      <div><label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:6px;">Role</label><div class="input-wrap"><svg class="i-left" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg><select class="form-input has-left"><option>Select role…</option><option>Admin</option><option>Editor</option><option>Viewer</option></select></div></div>
    </div>
    <div style="display:flex;gap:10px;margin-top:22px;padding-top:18px;border-top:1px solid var(--border);">
      <button @click="modal = false" class="btn btn-secondary" style="flex:1;justify-content:center;">Cancel</button>
      <button @click="modal = false" class="btn btn-primary" style="flex:1;justify-content:center;"><svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>Create User</button>
    </div>
  </div>
</div>`;

  // ─── Inject into layout wrapper ───
  const layout = document.getElementById('layout');
  if (!layout) return;

  layout.insertAdjacentHTML('afterbegin', sidebarHTML);

  const mainWrap = document.getElementById('main-wrap');
  if (mainWrap) {
    mainWrap.insertAdjacentHTML('afterbegin', topbarHTML);
    mainWrap.insertAdjacentHTML('beforeend', modalHTML);
  }
}
