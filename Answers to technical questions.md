# Answers to Technical Questions

## 1. How long did you spend on the coding test? What would you add with more time?

I spent approximately **1–2 hours** on this coding test, covering database design, PHP CRUD backend, the responsive frontend section, and documentation.

If I had more time, I would add:

- **Authentication** for the admin panel (login/session management) to protect CRUD operations
- **Input validation layer** with clearer error messages and server-side validation rules
- **Image optimization** on upload (resize to 1:1, compress, generate thumbnails)
- **Unit and integration tests** for the PHP data layer and API endpoints
- **Accessibility improvements** — full keyboard navigation for the slider, ARIA live regions for slide changes
- **Animation polish** — smoother slide transitions (CSS transforms instead of show/hide)
- **A proper migration/seed workflow** so the database can be set up with a single CLI command
- **Design fidelity review** against a full styleguide (fonts, exact spacing, breakpoints) if design files were available

---

## 2. How would you track down a performance issue in production? Have you ever had to do this?

Yes, I have investigated production performance issues. My approach follows a structured process:

1. **Confirm and scope the problem**
   - Check monitoring dashboards (e.g. New Relic, Datadog, Grafana) for spikes in response time, error rate, or resource usage
   - Identify when the issue started and whether it affects all users or a subset

2. **Reproduce and isolate**
   - Try to reproduce in staging with similar load
   - Use browser DevTools (Network, Performance tabs) for frontend issues
   - Check server logs, slow query logs, and APM transaction traces for backend bottlenecks

3. **Narrow down the layer**
   - **Frontend:** large assets, render-blocking scripts, excessive DOM manipulation, missing caching headers
   - **Backend:** N+1 queries, missing indexes, unoptimized SQL, synchronous external API calls
   - **Infrastructure:** CPU/memory limits, database connection pool exhaustion, CDN misconfiguration

4. **Fix and verify**
   - Apply a targeted fix (add an index, cache a query, lazy-load images, etc.)
   - Deploy to staging, run load tests, then roll out to production
   - Monitor metrics post-deploy to confirm the issue is resolved

5. **Prevent recurrence**
   - Add alerting thresholds, document the root cause, and add tests or monitoring for the specific failure mode

A concrete example: a page that loaded slowly because of an unindexed `JOIN` on a large table. I found it via MySQL slow query log, added a composite index, and response time dropped from ~2s to ~200ms.

---

## 3. Please describe yourself using JSON

```json
{
  "name": "Aswin Mohan",
  "role": "Full Stack Developer",
  "skills": [
    "PHP",
    "Laravel",
    "Node Js",
    "MySQL",
    "PostgreSQL",
    "JavaScript",
    "jQuery",
    "HTML5",
    "CSS3",
    "Bootstrap",
    "REST APIs",
    "Git"
  ],
  "strengths": [
    "Building responsive, data-driven web applications",
    "Clean, maintainable code following existing conventions",
    "Debugging across frontend and backend layers",
    "Translating design requirements into working UI"
  ],
  "approach": {
    "philosophy": "Understand the problem first, keep solutions simple, test thoroughly",
    "collaboration": "Clear communication, iterative delivery, open to feedback"
  },
  "interests": [
    "Web performance optimization",
    "Accessible UI design",
    "Continuous learning"
  ],
  "languages": ["English, Tamil"],
  "availability": "Open to new opportunities"
}
```
