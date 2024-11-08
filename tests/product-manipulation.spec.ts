import { test, expect } from '@playwright/test';

test('Product manipulation › Remove and add different products', async ({ page }) => {
    await page.goto('http://yourwebsite.com');

    const checkboxes = await page.locator('input[type="checkbox"]');
    const initialCount = await checkboxes.count();
    expect(initialCount).toBeGreaterThan(0);

    // Uncheck all checkboxes
    for (let i = 0; i < initialCount; i++) {
        await checkboxes.nth(i).uncheck();
    }

    // Wait for checkboxes to be unchecked
    const updatedCheckboxesCount = await page.locator('input[type="checkbox"]:checked').count();
    expect(updatedCheckboxesCount).toBe(0);

    // Ensure the ADD button is visible before clicking
    await page.waitForSelector('text=ADD', { state: 'visible', timeout: 60000 });
    await page.getByText('ADD').click();

    // Ensure the form becomes visible
    await expect(page.locator('#product_form')).toBeVisible({ timeout: 10000 });
});
