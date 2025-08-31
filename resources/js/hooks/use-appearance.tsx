export type Appearance = 'dark';

export function initializeTheme() {
    // Always enforce dark mode
    document.documentElement.classList.add('dark');
}

export function useAppearance() {
    // Always return 'dark' as the sole theme
    const appearance: Appearance = 'dark';
    const updateAppearance = () => {
        // Empty function - no theme switching allowed
    };

    return { appearance, updateAppearance } as const;
}