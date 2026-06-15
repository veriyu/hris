# AI Execution Rules

## Scope

Work only on the requested task.

Do not expand scope.

Do not suggest unrelated improvements.

---

## Context Usage

Read only files relevant to the task.

Never scan the entire project.

Never load unrelated modules.

Prefer targeted file inspection.

---

## Architecture

Assume current architecture is valid.

Do not redesign architecture unless requested.

Do not refactor unrelated code.

---

## Output

Be concise.

Avoid long explanations.

Return implementation first.

Explain only when necessary.

---

## Testing

Generate only tests required for the task.

Avoid excessive test generation.

---

## Performance

Minimize token usage.

Avoid repeated analysis.

Avoid repeating requirements already provided.

## Context Loading Order
Before answering any coding task, load:
1. standards/ai-rules.md
2. standards/coding-standard.md
3. standards/laravel-standard.md
4. standards/filament-5-standard.md
5. context/project-overview.md
6. context/architecture.md
7. memory/current-sprint.md

## Self Validation
Before outputting code:
- Verify framework versions.
- Verify API compatibility.
- Check that no deprecated syntax is used.

## Framework Version Rule
Never fallback to older framework examples because they are more familiar.
Current project versions always override pretrained knowledge.