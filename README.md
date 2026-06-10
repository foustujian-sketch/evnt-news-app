# >_EVNT // CORE_SYSTEM

![EVNT Platform](https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=1200&h=630)

**EVNT** is a brutalist-inspired, automated Tech News & Event aggregator. Built on the Laravel framework, it constantly scans and syncs the latest developer events, hackathons, and tech news via an automated cron-engine, presenting it in a high-contrast, heavy-border cyberpunk aesthetic.

## >_ SYS_FEATURES

- **Automated Aggregation Engine:** Hourly cron jobs fetch the latest global tech news via the NewsAPI.
- **Brutalist UI/UX:** Built with TailwindCSS, featuring thick borders, neo-brutalist shadows, uppercase monospaced typography, and neon accents.
- **Root Admin Dashboard:** Full CRUD control panel to moderate comments, manage user clearance levels, and manually trigger API syncs with a live Javascript countdown.
- **User Identity:** Secure authentication, custom profile management, and dynamically generated Robohash robot avatars.
- **Interaction Layer:** Users can bookmark 'Drops' via asynchronous AJAX requests and leave comments under specific events. Anti-spam rate limiting is built-in.
- **Notification Center:** In-app notification bell system alerts users when their clearance level is modified by an admin.

## >_ TECH_STACK

- **Backend:** Laravel 11.x, PHP 8.3
- **Database:** SQLite (Development) / MySQL/PostgreSQL (Production Ready)
- **Frontend:** Blade Templating, TailwindCSS, Vanilla JS
- **API Integration:** NewsAPI

## >_ INSTALLATION

To run the EVNT_CORE_SYSTEM locally on your machine:

1. **Clone the repository**
   ```bash
   git clone https://github.com/foustujian-sketch/evnt-platform.git
   cd evnt-platform
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install JS Dependencies & Build Assets**
   ```bash
   npm install
   npm run build
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Make sure to add your `NEWS_API_KEY` to the `.env` file!*

5. **Database Migration**
   ```bash
   php artisan migrate
   ```

6. **Boot System**
   ```bash
   php artisan serve
   ```

## >_ AUTOMATION

To run the automated news fetching locally, you must run the Laravel schedule worker:
```bash
php artisan schedule:work
```

## >_ DEVELOPER

Engineered and designed by **[Abdurrahman Al-Farisy](https://github.com/foustujian-sketch)**.
If you find a glitch in the matrix, feel free to reach out or submit an issue.

> "BUILD_FAST // HACK_THE_PLANET // SHIP_CODE"
