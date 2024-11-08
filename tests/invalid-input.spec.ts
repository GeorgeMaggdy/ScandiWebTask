import { test, expect } from '@playwright/test';

test('Invalid input handling', async ({ page }) => {
    await page.goto('http://yourwebsite.com', { timeout: 60000 });

    // Ensure the ADD button is visible before clicking
    await page.waitForSelector('text=ADD', { state: 'visible', timeout: 60000 });
    await expect(page.getByText('ADD')).toBeVisible({ timeout: 10000 });

    // Click the ADD button
    await page.getByText('ADD').click();

    // Ensure the form becomes visible
    await expect(page.locator('#product_form')).toBeVisible({ timeout: 10000 });

    // Fill the form with invalid inputs
    await page.fill('#sku', 'InvalidSKU');
    await page.fill('#name', '');
    await page.fill('#price', '-100');

    // Submit the form
    await page.locator('button[type="submit"]').click();

    // Expect error messages to be visible
    await expect(page.locator('.alert-danger')).toBeVisible({ timeout: 10000 });
});
