const drawer = () => {
  const menuButton = document.querySelector<HTMLElement>('#menu-button')
  const buttonText = document.querySelector<HTMLElement>('#menu-button span')
  const siteNavigation = document.querySelector<HTMLElement>('#site-navigation')
  const backdrop = document.querySelector<HTMLElement>('.backdrop')
  const scrollbarFixTargets =
    document.querySelectorAll<HTMLElement>('.scrollbar-fix')

  const rootElement = document.documentElement
  const scrollLockModifier = 'drawer-open'

  let drawerOpen = false
  let scrollbarFix = false

  const changeAriaExpanded = (state: boolean) => {
    const booleanValue = state ? 'true' : 'false'
    siteNavigation?.setAttribute('aria-expanded', booleanValue)
    menuButton?.setAttribute('aria-expanded', booleanValue)
  }

  const changeText = (textValue: string) => {
    if (!buttonText) return
    buttonText.textContent = textValue
  }

  const changeState = (state: boolean) => {
    if (state === drawerOpen) return
    changeAriaExpanded(state)
    drawerOpen = state
  }

  const openDrawer = () => {
    changeState(true)
    changeText('Close')
  }

  const closeDrawer = () => {
    changeState(false)
    changeText('Menu')
  }

  const addScrollbarMargin = (value: string) => {
    if (!scrollbarFixTargets) return
    const targetsLength = scrollbarFixTargets.length
    for (let i = 0; i < targetsLength; i += 1) {
      scrollbarFixTargets[i].style.marginRight = value
    }
  }

  const addScrollbarWidth = () => {
    const scrollbarWidth = window.innerWidth - rootElement.clientWidth
    if (!scrollbarWidth) {
      scrollbarFix = false

      return
    }
    const value = `${scrollbarWidth}px`
    addScrollbarMargin(value)
    scrollbarFix = true
  }

  const removeScrollbarWidth = () => {
    if (!scrollbarFix) {
      return
    }
    addScrollbarMargin('')
  }

  const activateScrollLock = () => {
    addScrollbarWidth()
    rootElement.classList.add(scrollLockModifier)
  }

  const deactivateScrollLock = () => {
    removeScrollbarWidth()
    rootElement.classList.remove(scrollLockModifier)
  }

  const onClickButton = () => {
    if (drawerOpen) {
      closeDrawer()
    } else {
      activateScrollLock()
      openDrawer()
    }
  }

  const onTransitionedDrawer = (event: Event) => {
    if (event.target !== siteNavigation) {
      return
    }
    if (!drawerOpen) {
      deactivateScrollLock()
      removeScrollbarWidth()
    }
  }

  menuButton?.addEventListener('click', onClickButton)
  backdrop?.addEventListener('click', onClickButton)
  siteNavigation?.addEventListener('transitionend', onTransitionedDrawer)
}

export default drawer
