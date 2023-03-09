targetScope = 'resourceGroup'

param acrName string
param appPrincipalId string

resource acr 'Microsoft.ContainerRegistry/registries@2021-09-01' existing = {
  name: acrName
}

/*
 * acr app role for container pull
 */
@description('This is the built-in ACR pull User role. See https://learn.microsoft.com/en-us/azure/role-based-access-control/built-in-roles#acrpull')
resource useRoleDefinition 'Microsoft.Authorization/roleDefinitions@2018-01-01-preview' existing = {
  scope: acr
  name: '7f951dda-4ed3-4680-a7ca-43fe172d538d'
}

resource useRoleAssignment 'Microsoft.Authorization/roleAssignments@2020-04-01-preview' = {
  name: guid(resourceGroup().id, appPrincipalId, useRoleDefinition.id)
  scope: acr
  properties: {
    roleDefinitionId: useRoleDefinition.id
    principalId: appPrincipalId
    principalType: 'ServicePrincipal'
  }
}
