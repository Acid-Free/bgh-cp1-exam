/** Formats date in string date */
export const formatDate = (date: Date): string => {
  const formattedDate = new Date(date)
  return formattedDate.toLocaleString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

/** Formats date in string datetime */
export const formatDatetime = (date: Date): string => {
  const formattedDate = new Date(date)
  return formattedDate.toLocaleString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: 'numeric',
    minute: 'numeric'
  })
}

/** Formats date in string time */
export const formatTime = (date: Date): string => {
  const formattedDate = new Date(date)
  return formattedDate.toLocaleString('en-US', {
    hour: 'numeric',
    minute: 'numeric'
  })
}
