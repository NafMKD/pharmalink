
# Git Usage Policy

This document defines the rules and best practices for using Git in this repository.  
All contributors are required to follow these guidelines to maintain a clean, consistent, and collaborative workflow.

---

## 1. Branching Strategy

- **Main Branch (`main`)**
  - Always stable and deployable.
  - No direct commits allowed — only pull requests (PRs) can be merged.
  - Protected with required reviews and CI checks.

- **Feature Branches**
  - Use for new features or enhancements.
  - Naming convention:  
    ```
    feature/<short-description>
    ```
    Example: `feature/salesperson-verification`

- **Bugfix Branches**
  - Use for fixing bugs in the current release.
  - Naming convention:  
    ```
    bugfix/<short-description>
    ```
    Example: `bugfix/chat-message-duplication`

- **Hotfix Branches**
  - Use for urgent fixes on production.
  - Naming convention:  
    ```
    hotfix/<short-description>
    ```
    Example: `hotfix/payment-crash`

---

## 2. Commit Message Rules

- Use the following convention:
    ```
    <type>(<scope>): <short summary>
    ```
Types include:
- `feat` → New feature
- `fix` → Bug fix
- `docs` → Documentation changes
- `style` → Formatting (no logic change)
- `refactor` → Code restructuring
- `test` → Adding/fixing tests
- `chore` → Maintenance tasks

Examples:
    ```
    feat(auth): add login with phone number
    ```

> Keep commit messages concise but descriptive.

---

## 3. Pull Requests (PRs)

- Always create a PR for merging into `main`.
- PRs must:
- Be reviewed by at least **one other developer** before merging.
- Pass all automated tests and checks.
- Include a clear description of changes.
- Reference related issues using GitHub keywords:
  - Example: `Fixes #45` or `Closes #72`

---

## 4. Code Review Guidelines

- Be respectful and constructive.
- Check for:
    - Code readability and maintainability.
    - Adherence to style and architecture guidelines.
    - Proper tests and documentation updates.
    - Request changes when necessary.
    - Approve only if you are confident in the quality of the contribution.

---

## 5. Tagging & Releases

- Tags are created from `main` for release versions.
- Use **semantic versioning**:
    ```
    v<major>.<minor>.<patch>
    ```
- `major` → Breaking changes
- `minor` → New features, backward-compatible
- `patch` → Bug fixes, small updates

Example: `v1.3.0`

---

## 6. General Rules

- **Never commit secrets** (API keys, credentials, etc.).
- Keep PRs small and focused (avoid large, mixed changes).
- Write meaningful commit messages.
- Rebase before merging if needed to keep history clean.
- Follow the repository’s coding style and linting rules.
- Always test locally before pushing.

---

## 7. Example Workflow

1. Create a new branch:
    ```bash
    git checkout main
    git pull origin main
    git checkout -b feature/salesperson-verification
    ```

2. Work on your changes, commit with clear messages:

   ```bash
   git commit -m "feat(sales): implement salesperson verification flow"
   ```

3. Push to remote:

   ```bash
   git push origin feature/salesperson-verification
   ```

4. Open a Pull Request to `main`.

---

