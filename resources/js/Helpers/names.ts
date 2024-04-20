/**
 * Returns full name in the following format: [Last Name], [First Name] [Middle Name] [Suffix]
 */
export const formatName = (
  lastName: string,
  firstName: string,
  middleName?: string,
  suffix?: string
): string => {
  let fullName: string = `${lastName}, ${firstName}`

  if (middleName) {
    fullName += ` ${middleName}`
  }

  if (suffix) {
    fullName += ` ${suffix}`
  }

  return fullName
}
