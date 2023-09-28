// eslint-disable-next-line no-restricted-imports
import { type Component, createApp as vuecreateApp, type App } from 'vue'

export function createApp (component: Component, rootProps: Record<string, unknown> | null = null): App {
    const app = vuecreateApp(component, rootProps)
    return app
}
