targetScope = 'subscription'

param prNumber string = 'latest'
param containerTag string = 'latest'
param dbServerRG string
param dbServerName string
param dbServerPass string
param subnetID string
param planID string
param acrName string = 'collabtestacr'
param siteType string = 'gccollab'

param location string = 'Canada Central'

resource testRG 'Microsoft.Resources/resourceGroups@2021-01-01' = {
  name: 'collab_review_${prNumber}'
  location: location
}

module collab './collab-test-instance.bicep' = {
  name: 'collab-test-infra'
  scope: resourceGroup(testRG.name)
  params: {
    containerTag: containerTag
    prName: 'PR-${prNumber}'
    subnetID: subnetID
    planID: planID
    dbServerRG: dbServerRG
    dbServerName: dbServerName
    dbServerPass: dbServerPass
    acrName: acrName
    siteType: siteType
  }
}
